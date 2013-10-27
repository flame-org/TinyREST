<?php
/**
 * Class BaseErrorRestPresenter
 *
 * @author: Jiří Šifalda <sifalda.jiri@gmail.com>
 * @date: 26.10.13
 */
namespace Flame\Rest\Application\UI;

abstract class BaseErrorRestPresenter extends RestPresenter
{

	/**
	 * @param \Exception $ex
	 */
	public function actionDefault($ex)
	{
		if($ex instanceof \Exception) {
			$this->sendErrorResource($ex);
		}
	}
} 