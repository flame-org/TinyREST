<?php
/**
 * Class RestRoute
 *
 * @author: Jiří Šifalda <sifalda.jiri@gmail.com>
 * @date: 27.10.13
 */
namespace Flame\Rest\Application\Routers;

use Nette\Application\IRouter;
use Nette\Http\Request as HttpRequest;
use Nette\Application\Request;
use Nette\Http\IRequest;
use Nette\Http\Url;
use Nette\InvalidStateException;
use Nette\Utils\Strings;

/**
 * @author Adam Štipák <adam.stipak@gmail.com>
 * @author: Jiří Šifalda <sifalda.jiri@gmail.com>
 */
class RestRoute implements IRouter
{

	const HTTP_HEADER_OVERRIDE = 'X-HTTP-Method-Override';
	const QUERY_PARAM_OVERRIDE = '__method';

	/** @var string */
	protected $path;

	/** @var string */
	protected $module;

	/** @var array */
	protected $formats = array(
		'json' => 'application/json',
		'xml' => 'application/xml',
	);

	/** @var string */
	private $requestUrl;

	/**
	 * @param null $module
	 */
	public function __construct($module = null)
	{
		$this->module = $module;
	}

	/**
	 * @return string
	 */
	public function getPath()
	{
		$path = implode('/', explode(':', $this->module));
		$this->path = strtolower($path);

		return (string)$this->path;
	}

	/**
	 * Maps HTTP request to a Request object.
	 *
	 * @param \Nette\Http\IRequest $httpRequest
	 * @return \Nette\Application\Request|NULL
	 */
	public function match(IRequest $httpRequest)
	{
		$url = $httpRequest->getUrl();
		$basePath = str_replace('/', '\/', $url->getBasePath());
		$cleanPath = preg_replace("/^{$basePath}/", '', $url->getPath());

		$path = str_replace('/', '\/', $this->getPath());
		$pathRexExp = empty($path) ? "/^.+$/" : "/^{$path}\/.*$/";
		if (!preg_match($pathRexExp, $cleanPath)) {
			return null;
		}

		$cleanPath = preg_replace('/^' . $path . '\//', '', $cleanPath);

		$params = array();
		$path = $cleanPath;
		$params['action'] = $this->detectAction($httpRequest);
		$frags = explode('/', $path);

		// Resource ID.
		if (count($frags) % 2 === 0) {
			$params['id'] = array_pop($frags);
		} elseif ($params['action'] == 'read' && !@$params['id']) {
			$params['action'] = 'readAll';
		}
		$presenterName = ucfirst(array_pop($frags));

		// Allow to use URLs like domain.tld/presenter.format.
		$formats = join('|', array_keys($this->formats));
		if (Strings::match($presenterName, "/.+\.({$formats})$/")) {
			list($presenterName, $format) = explode('.', $presenterName);
		}

		// Associations.
		$assoc = array();
		if (count($frags) > 0 && count($frags) % 2 === 0) {
			foreach ($frags as $k => $f) {
				if ($k % 2 !== 0)
					continue;

				$assoc[$f] = $frags[$k + 1];
			}
		}

		$params['format'] = $this->detectFormat($httpRequest);
		$params['associations'] = $assoc;
		$params['query'] = $httpRequest->getQuery();

		$presenterName = empty($this->module) ? $presenterName : $this->module . ':' . $presenterName;

		// Remember absolute URL for ::constructUrl(). It is one way route ;-).
		$this->requestUrl = $url->getAbsoluteUrl();

		return new Request(
			$presenterName,
			$httpRequest->getMethod(),
			$params
		);
	}

	/**
	 * @param HttpRequest $request
	 * @return string
	 * @throws \Nette\InvalidStateException
	 */
	protected function detectAction(HttpRequest $request)
	{
		$method = $this->detectMethod($request);

		switch ($method) {
			case 'GET':
				$action = 'read';
				break;
			case 'POST':
				$action = 'create';
				break;
			case 'PUT':
				$action = 'update';
				break;
			case 'DELETE':
				$action = 'delete';
				break;
			default:
				throw new InvalidStateException('Method ' . $method . ' is not allowed.');
		}

		return $action;
	}

	/**
	 * @param \Nette\Http\Request $request
	 *
	 * @return string
	 */
	protected function detectMethod(HttpRequest $request)
	{
		$requestMethod = $request->getMethod();
		if ($requestMethod !== 'POST') {
			return $request->getMethod();
		}

		$method = $request->getHeader(self::HTTP_HEADER_OVERRIDE);
		if (isset($method)) {
			return strtoupper($method);
		}

		$method = $request->getQuery(self::QUERY_PARAM_OVERRIDE);
		if (isset($method)) {
			return strtoupper($method);
		}

		return $requestMethod;
	}

	/**
	 * @param \Nette\Http\Request $request
	 * @return string
	 */
	private function detectFormat(HttpRequest $request)
	{
		// Try retrieve fallback from URL.
		$path = $request->getUrl()->getPath();
		$formats = array_keys($this->formats);
		$formats = implode('|', $formats);
		if (Strings::match($path, "/\.({$formats})$/")) {
			list($path, $format) = explode('.', $path);
			return $format;
		}

		$header = $request->getHeader('Accept'); // http://www.w3.org/Protocols/rfc2616/rfc2616-sec14.html
		foreach ($this->formats as $format => $fullFormatName) {
			$fullFormatName = Strings::replace($fullFormatName, '/\//', '\/');
			if (Strings::match($header, "/{$fullFormatName}/")) {
				return $format;
			}
		}

	}

	/**
	 * Constructs absolute URL from Request object.
	 *
	 * @param \Nette\Application\Request $appRequest
	 * @param \Nette\Http\Url $refUrl
	 * @throws \Nette\InvalidStateException
	 * @return string|NULL
	 */
	public function constructUrl(Request $appRequest, Url $refUrl)
	{
		// Module prefix not match.
		if ($this->module && !Strings::startsWith($appRequest->getPresenterName(), $this->module)) {
			return null;
		}

		$parameters = $appRequest->getParameters();
		$urlStack = array();

		// Module prefix.
		$moduleFrags = explode(":", Strings::lower($appRequest->getPresenterName()));
		$resourceName = array_pop($moduleFrags);
		$urlStack += $moduleFrags;

		// Associations.
		if (isset($parameters['associations']) && is_array($parameters['associations'])) {
			$associations = & $parameters['associations'];

			foreach ($associations as $key => $value) {
				$urlStack[] = $key;
				$urlStack[] = $value;
			}
		}

		// Resource.
		$urlStack[] = Strings::lower($resourceName);

		// Id.
		if (isset($parameters['id']) && is_scalar($parameters['id'])) {
			$urlStack[] = $parameters['id'];
		}

		$sep = ini_get('arg_separator.input');
		$query = http_build_query($parameters['query'], '', $sep ? $sep[0] : '&');
		return $refUrl->getBaseUrl() . implode('/', $urlStack) . '?' . $query;
	}
}
