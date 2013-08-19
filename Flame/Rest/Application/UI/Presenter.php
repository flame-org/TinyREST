<?php
/**
 * Class Presenter
 *
 * @author: Jiří Šifalda <sifalda.jiri@gmail.com>
 * @date: 19.08.13
 */
namespace Flame\Rest\Application\UI;

use Flame\Rest\Response\JsonResponse;
use Nette;

class Presenter extends Nette\Application\UI\Presenter
{

	/**
	 * Sends JSON data to the output.
	 * @param  mixed $data
	 * @return void
	 * @throws Nette\Application\AbortException
	 */
	public function sendJson($data)
	{
		$this->sendResponse(new JsonResponse($data));
	}

}