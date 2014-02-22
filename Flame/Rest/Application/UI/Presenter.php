<?php
/**
 * Class Presenter
 *
 * @author: Jiří Šifalda <sifalda.jiri@gmail.com>
 * @date: 19.08.13
 */
namespace Flame\Rest\Application\UI;

use Nette;
use Nette\Application\Responses\JsonResponse;

abstract class Presenter extends Nette\Application\UI\Presenter
{
	/**
	 * @inject
	 * @var \Nette\Application\Application
	 */
	public $application;

	/**
	 * @return void
	 */
	protected function startup()
	{
		parent::startup();

		$this->application->onError[] = function ($application, $exception) {
			if ($exception instanceof \Exception) {
				$this->sendErrorResource($exception);
			}
		};
	}

	/**
	 * Sends JSON data to the output.
	 * @param  mixed $data
	 * @return void
	 * @throws Nette\Application\AbortException
	 */
	public function sendJson($data)
	{
		if ($data === null) {
			$this->terminate();
		}else{
			$this->sendResponse(new JsonResponse($data));
		}
	}

	/**
	 * @param \Exception $ex
	 * @param bool $log
	 */
	abstract public function sendErrorResource(\Exception $ex, $log = false);

	/**
	 * @param int $code
	 */
	abstract public function sendResource($code = Nette\Http\IResponse::S200_OK);

}