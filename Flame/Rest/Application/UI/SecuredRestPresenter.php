<?php
/**
 * Class RestAclPresenter
 *
 * @author: Jiří Šifalda <sifalda.jiri@gmail.com>
 * @date: 20.07.13
 */
namespace Flame\Rest\Application\UI;

use Nette\Application\BadRequestException;
use Nette\Utils\Strings;

class SecuredRestPresenter extends RestPresenter
{

	/** @var bool */
	protected $checkRequestMethod = false;

	/**
	 * @param $element
	 */
	public function checkRequirements($element)
	{
		try {

			$this->authentication->authenticate($element);

			if($this->checkRequestMethod === true) {
				$this->checkRequestMethod($element);
			}
		} catch (\Exception $ex) {
			$this->sendErrorResource($ex);
		}
	}

	/**
	 * @param $element
	 * @throws \Nette\Application\BadRequestException
	 */
	private function checkRequestMethod($element)
	{
		if($method = $element->getAnnotation('method')) {
			if (Strings::upper($method) !== Strings::upper($this->getHttpRequest()->getMethod())) {
				throw new BadRequestException('Bad HTTP method for the request.');
			}
		}
	}

}