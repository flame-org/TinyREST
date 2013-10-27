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
use Nette\Http\IResponse;
use Flame\Rest\Security\Authentication;
use Nette\Diagnostics\Debugger;

/**
 * Class RestPresenter
 *
 * @package Flame\Rest\Application\UI
 */
abstract class RestPresenter extends Presenter
{

	/** @var  \Flame\Rest\ExtendedResource */
	protected $resource;

	/** @var  \Flame\Rest\Security\Authentication */
	protected $authentication;

	/** @var  IParametersFactory */
	private $parametersFactory;

	/** @var  Parameters */
	private $requestParameters;

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
		$this->resource = $resourceFactory->create();
		$this->authentication = $authentication;
		$this->parametersFactory = $paramsFactory;
	}

	/**
	 * @return Parameters
	 */
	public function getRequestParameters()
	{
		return $this->requestParameters;
	}

	/**
	 * @param $element
	 */
	public function checkRequirements($element)
	{
		try {
			$user = (array) $element->getAnnotation('User');
			if (in_array('loggedIn', $user) && !$this->user->isLoggedIn()) {
				$this->authentication->authenticate($this->getRequestParameters());
			}
		} catch (\Exception $ex) {
			$this->sendErrorResource($ex);
		}
	}

	/**
	 * @param \Exception $ex
	 * @param bool $log
	 */
	public function sendErrorResource(\Exception $ex, $log = true)
	{
		$code = $ex->getCode();
		if ($code < 100 || $code > 599) {
			$code = 400;
		}

		if($log === true) {
			Debugger::log($ex, Debugger::ERROR);
		}

		$this->resource->message = $ex->getMessage();
		$this->resource->type = 'error';
		$this->sendResource($code);
	}

	/**
	 * @param int $code
	 */
	public function sendResource($code = IResponse::S200_OK)
	{
		$this->getHttpResponse()->setCode($code);
		$this->sendJson($this->resource->getData());
	}

	/**
	 * @return void
	 */
	protected function startup()
	{
		parent::startup();

		$this->requestParameters = $this->parametersFactory->create($this->params);
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
