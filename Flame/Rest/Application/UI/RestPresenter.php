<?php
/**
 * RestPresenter.php
 *
 * @author  Jiří Šifalda <sifalda.jiri@gmail.com>
 * @date    05.02.13
 */

namespace Flame\Rest\Application\UI;

use Flame\Rest\IResourceFactory;
use Flame\Rest\Request\Parameters;
use Flame\Rest\Response\Code;
use Flame\Rest\Response\ICode;
use Flame\Rest\Security\Authentication;
use Nette\Diagnostics\Debugger;

/**
 * Class RestPresenter
 *
 * @package Flame\Rest\Application\UI
 */
abstract class RestPresenter extends Presenter
{

	/** @var  \Flame\Rest\Response\Code */
	protected $code;

	/** @var  \Flame\Rest\ExtendedResource */
	protected $resource;

	/** @var  \Flame\Rest\Security\Authentication */
	protected $authentication;

	/** @var  Parameters */
	private $requestParameters;

	public function __construct()
	{
		$this->setRequestParameters($this->params);
	}

	/**
	 * @param IResourceFactory $resourceFactory
	 * @param ICode $code
	 * @param Authentication $authentication
	 */
	final public function injectRestServices(IResourceFactory $resourceFactory, ICode $code, Authentication $authentication)
	{
		$this->resource = $resourceFactory->create();
		$this->authentication = $authentication;
		$this->code = $code;
	}

	/**
	 * @param array $requestParameters
	 * @return $this
	 */
	public function setRequestParameters(array $requestParameters)
	{
		$this->requestParameters = new Parameters($requestParameters);
		return $this;
	}

	/**
	 * @return Parameters
	 */
	public function getRequestParameters()
	{
		return $this->requestParameters;
	}

	/**
	 * @param \Exception $ex
	 * @param bool $log
	 */
	public function sendErrorResource(\Exception $ex, $log = true)
	{
		$code = 500;
		$exCode = $ex->getCode();

		if ($exCode && in_array($exCode, $this->code->getCodes())) {
			$code = $ex->getCode();
		}

		if($log === true) {
			Debugger::log($ex, Debugger::ERROR);
		}

		$this->resource->message = $ex->getMessage();
		$this->sendResource($code);
	}

	/**
	 * @param int $code
	 */
	public function sendResource($code = Code::S200_OK)
	{
		$this->getHttpResponse()->setCode($code);
		$this->sendJson($this->resource->getData());
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
