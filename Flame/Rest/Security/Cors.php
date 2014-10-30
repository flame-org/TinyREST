<?php
/**
 * Class Cors
 *
 * @author Jiří Šifalda <sifalda.jiri@gmail.com>
 * @date 22.02.14
 */
namespace Flame\Rest\Security;

use Nette\Http\Request;
use Nette\Http\Response;
use Nette\Object;

class Cors extends Object implements ICors
{

	/** @var  Response */
	private $httpResponse;

	/** @var Request  */
	private $httpRequest;

	/** @var  array|null */
	private $config;

	/**
	 * @param Request $httpRequest
	 * @param Response $httpResponse
	 */
	function __construct(Request $httpRequest, Response $httpResponse)
	{
		$this->httpRequest = $httpRequest;
		$this->httpResponse = $httpResponse;
	}

	/**
	 * @param mixed $config
	 * @return $this
	 */
	public function setConfig(array $config)
	{
		$this->config = $config;
		return $this;
	}

	/**
	 * @return $this
	 */
	public function configure()
	{
		$this->httpResponse->addHeader(self::HEADER_ORIGIN, $this->getOrigin());
		$this->httpResponse->addHeader(self::HEADER_HEADERS, $this->getHeaders());
		$this->httpResponse->addHeader(self::HEADER_METHODS, $this->getMethods());
	}

	/**
	 * @return string|null
	 */
	public function getOrigin()
	{
		if (isset($this->config['origin'])) {
			if ($this->config['origin'] === '*' && isset($_SERVER['HTTP_ORIGIN'])) {
				$this->config['origin'] = $_SERVER['HTTP_ORIGIN'];
			}

			if (is_array($this->config['origin'])) {
				$this->config['origin'] = implode(',', $this->config['origin']);
			}

			return (string) $this->config['origin'];
		}
	}

	/**
	 * @return string|null
	 */
	public function getHeaders()
	{
		if (isset($this->config['headers'])) {
			if ($this->config['headers'] === '*') {
				$headers = array('origin', 'content-type', 'authorization');
				/*
				 * Because OPTIONS requests aren't contain declared headers but send list of
				 * headers in Access-Control-Request-Headers header
				 */
				$expectedHeaders = $this->httpRequest->getHeader("Access-Control-Request-Headers", []);
				if (!empty($expectedHeaders)) {
					$expectedHeaders = array_map('trim', explode(",", $expectedHeaders));
				}
				$this->config['headers'] = array_merge($headers, array_keys((array) $this->httpRequest->getHeaders()), $expectedHeaders);
			}

			if (is_array($this->config['headers'])) {
				$this->config['headers'] = implode(',', $this->config['headers']);
			}

			return (string) $this->config['headers'];
		}
	}

	/**
	 * @return string|null
	 */
	public function getMethods()
	{
		if (isset($this->config['methods'])) {
			if ($this->config['methods'] === '*' && $this->httpRequest->getMethod() === 'OPTIONS') {
				$this->config['methods'] = array('GET','DELETE', 'PUT', 'POST','OPTIONS','HEAD','TRACE','CONNECT', 'PATCH', 'COPY', 'SEARCH');
			}
			if (is_array($this->config['methods'])) {
				$this->config['methods'] = implode(',', $this->config['methods']);
			}

			return (string) $this->config['methods'];
		}
	}
}