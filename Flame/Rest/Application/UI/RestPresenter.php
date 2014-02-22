<?php
/**
 * RestPresenter.php
 *
 * @author  Jiří Šifalda <sifalda.jiri@gmail.com>
 * @date    05.02.13
 */

namespace Flame\Rest\Application\UI;

use Nette;

/**
 * Class RestPresenter
 *
 * @package Flame\Rest\Application\UI
 *
 * @property-read \Flame\Rest\Request\Parameters $input
 * @property-read \Flame\Rest\Resource $resource
 */
abstract class RestPresenter extends Presenter
{

	/**
	 * @inject
	 * @var  \Flame\Rest\Security\Authentication
	 */
	public $authentication;

	/**
	 * @inject
	 * @var  \Flame\Rest\Security\ICors
	 */
	public $cors;

	/**
	 * @inject
	 * @var  \Flame\Rest\Request\IParametersFactory
	 */
	public $parametersFactory;

	/**
	 * @inject
	 * @var  \Flame\Rest\IResourceFactory
	 */
	public $resourceFactory;

	/**
	 * @var \Flame\Rest\Request\Parameters
	 * */
	private $input;

	/**
	 * @var \Flame\Rest\Resource
	 */
	private $resource;

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
	 * @return \Flame\Rest\Request\Parameters
	 */
	public function getInput()
	{
		if($this->input === null) {
			$this->input = $this->parametersFactory->create($this->params);
		}

		return $this->input;
	}

	/**
	 * @param $element
	 */
	public function checkRequirements($element)
	{
		try {
			if ($element instanceof Nette\Reflection\Method) {
				$this->authentication->authenticate($element);
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

	/**
	 * @param  Nette\Application\IResponse
	 * @return void
	 */
	protected function shutdown($response)
	{
		$this->cors->configure($this->getInput());
		parent::shutdown($response);
	}
}
