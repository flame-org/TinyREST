<?php
/**
 * RestPresenter.php
 *
 * @author  Jiří Šifalda <sifalda.jiri@gmail.com>
 * @date    05.02.13
 */

namespace Flame\Rest\Application\UI;

use Flame\Rest\Request\Parameters;
use Nette\Application\UI\Presenter;
use Flame\Rest\Response\IResponse;
use Nette\Application\ForbiddenRequestException;
use Flame\Rest\IResource;

abstract class RestPresenter extends Presenter
{

	/**
	 * @inject
	 * @var \Flame\Rest\ResourceFactory
	 */
	public $resourceFactory;

	/**
	 * @inject
	 * @var \Flame\Rest\Tools\Parser
	 */
	public $parser;

	/** @var  IResource */
	protected $resource;

	/**
	 * @return Parameters
	 */
	public function getRequestParameters()
	{
		return new Parameters($this->parser, $this->getParameters());
	}

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
	 */
	public function sendErrorResource(\Exception $ex)
	{
		$code = 500;

		if ($ex->getCode()) {
			$code = $ex->getCode();
		}

		$this->resource->message = $ex->getMessage();
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
	 * On before render
	 */
	protected function beforeRender()
	{
		parent::beforeRender();
		$this->sendResource();
	}

	/**
	 * @return void
	 */
	protected function startup()
	{
		parent::startup();

		$this->resource = $this->resourceFactory->create();
	}
}
