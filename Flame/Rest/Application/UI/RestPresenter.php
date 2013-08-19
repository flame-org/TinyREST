<?php
/**
 * RestPresenter.php
 *
 * @author  Jiří Šifalda <sifalda.jiri@gmail.com>
 * @date    05.02.13
 */

namespace Flame\Rest\Application\UI;

use Flame\Rest\Request\Parameters;
use Flame\Rest\Response\Code;
use Nette\Application\ForbiddenRequestException;
use Nette\Diagnostics\Debugger;

/**
 * Class RestPresenter
 *
 * @package Flame\Rest\Application\UI
 * @method \Flame\Rest\Request\Parameters getRequestParameters
 */
abstract class RestPresenter extends Presenter
{

	/** @var  \Flame\Rest\Tools\Parser */
	protected $parser;

	/** @var  \Flame\Rest\Response\Code */
	public $code;

	/** @var  \Flame\Rest\ExtendedResource */
	protected $resource;

	/** @var  Parameters */
	protected $requestParameters;

	/**
	 * @param $element
	 */
	public function checkRequirements($element)
	{
		try {
			parent::checkRequirements($element);
		} catch (ForbiddenRequestException $ex) {
			$this->sendErrorResource($ex);
		}
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
	 * @return void
	 */
	protected function startup()
	{
		parent::startup();

		$this->resource = $this->context->getByType('\Flame\Rest\IResourceFactory')->create();
		$this->code = $this->context->getByType('\Flame\Rest\ICode');
		$this->requestParameters = new Parameters($this->parser, $this->params);
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
