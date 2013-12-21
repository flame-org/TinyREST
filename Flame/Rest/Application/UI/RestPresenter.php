<?php
/**
 * RestPresenter.php
 *
 * @author  Jiří Šifalda <sifalda.jiri@gmail.com>
 * @date    05.02.13
 */

namespace Flame\Rest\Application\UI;

use Flame\Rest\IResourceFactory;
use Flame\Rest\Request\IParametersFactory;
use Flame\Rest\Request\Parameters;
use Flame\Rest\Security\Authentication;
use Nette;

/**
 * Class RestPresenter
 *
 * @package Flame\Rest\Application\UI
 *
 * @property-read Parameters $input
 * @property-read \Flame\Rest\Resource $resource
 */
abstract class RestPresenter extends Presenter
{

	/** @var  \Flame\Rest\Security\Authentication */
	protected $authentication;

	/** @var  IParametersFactory */
	private $parametersFactory;

	/** @var  Parameters */
	private $input;

	/** @var  \Flame\Rest\Resource */
	private $resource;

	/** @var  IResourceFactory */
	private $resourceFactory;

	/**
	 * @param IResourceFactory $resourceFactory
	 * @param Authentication $authentication
	 * @param IParametersFactory $paramsFactory
	 */
	final public function injectRestServices(
		IResourceFactory $resourceFactory,
		Authentication $authentication,
		IParametersFactory $paramsFactory)
	{
		$this->resourceFactory = $resourceFactory;
		$this->authentication = $authentication;
		$this->parametersFactory = $paramsFactory;
	}

	/**
	 * @return \Flame\Rest\Resource
	 */
	public function getResource()
	{
		if($this->resource === null) {
			$this->resource = $this->resourceFactory->create();
		}

		return $this->resource;
	}

	/**
	 * @return Parameters
	 */
	public function getInput()
	{
		if($this->input === null) {
			$this->input = $this->parametersFactory->create($this->params);
		}

		return $this->input;
	}

	/**
	 * @return Parameters
	 * @deprecated
	 */
	public function getRequestParameters()
	{
		return $this->getInput();
	}

	/**
	 * @param $element
	 */
	public function checkRequirements($element)
	{
		try {
			$user = (array) $element->getAnnotation('User');
			if (in_array('loggedIn', $user)) {
				$this->authentication->authenticate();
			}
		} catch (\Exception $ex) {
			$this->sendErrorResource($ex);
		}
	}

	/**
	 * @param \Exception $ex
	 * @param bool $log
	 */
	public function sendErrorResource(\Exception $ex, $log = false)
	{
		$code = $ex->getCode();
		if ($code < 100 || $code > 599) {
			$code = 400;
		}

		if($log === true) {
			Nette\Diagnostics\Debugger::log($ex, Nette\Diagnostics\Debugger::ERROR);
		}

		if($message = $ex->getMessage()) {
			$this->getResource()->message = $message;
		}
		$this->getResource()->code = $code;
		$this->getResource()->type = 'error';

		$this->sendResource($code);
	}

	/**
	 * @param int $code
	 */
	public function sendResource($code = Nette\Http\IResponse::S200_OK)
	{
		$this->getHttpResponse()->setCode($code);
		$this->sendJson($this->getResource()->getData());
	}

	/**
	 * On before render
	 */
	protected function beforeRender()
	{
		parent::beforeRender();
		$this->sendResource();
	}
}
