<?php
/**
 * Class Application
 *
 * @author: Jiří Šifalda <sifalda.jiri@gmail.com>
 * @date: 26.10.13
 */
namespace Flame\Rest\Application;

use Flame\Rest\Application\UI\RestPresenter;

class Application extends \Nette\Application\Application
{

	/** @var  string */
	private $restErrorPresenter = 'ErrorRest';

	/**
	 * @param string $restErrorPresenter
	 * @return $this
	 */
	public function setRestErrorPresenter($restErrorPresenter)
	{
		$this->restErrorPresenter = (string) $restErrorPresenter;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getRestErrorPresenter()
	{
		return $this->restErrorPresenter;
	}



	/**
	 * @param \Exception $ex
	 */
	public function processException(\Exception $ex)
	{
		if($this->presenter instanceof RestPresenter) {
			$this->errorPresenter = $this->getRestErrorPresenter();
		}

		parent::processException($ex);
	}
} 