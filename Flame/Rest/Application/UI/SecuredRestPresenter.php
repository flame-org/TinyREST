<?php
/**
 * Class RestAclPresenter
 *
 * @author: Jiří Šifalda <sifalda.jiri@gmail.com>
 * @date: 20.07.13
 */
namespace Flame\Rest\Application\UI;

use Nette\Application\ForbiddenRequestException;
use Nette\Utils\Strings;

class SecuredRestPresenter extends RestPresenter
{

	/** @var bool */
	protected $checkUserRole = true;

	/** @var bool */
	protected $checkRequestMethod = false;

	/**
	 * @param $element
	 */
	public function checkRequirements($element)
	{
		try {

			parent::checkRequirements($element);

			if($this->checkRequestMethod === true) {
				$this->checkRequestMethod($element);
			}

			if($this->checkUserRole === true) {
				$this->checkUserRole($element);
			}

		} catch (ForbiddenRequestException $ex) {
			$this->sendErrorResource($ex);
		}
	}

	/**
	 * @param $element
	 * @throws \Nette\Application\ForbiddenRequestException
	 */
	private function checkUserRole($element)
	{
		if($role = $element->getAnnotation('role')) {
			if (!$this->getUser()->isInRole($role)) {
				throw new ForbiddenRequestException('You don\'t have permissions for this action.');
			}
		}
	}

	/**
	 * @param $element
	 * @throws \Nette\Application\ForbiddenRequestException
	 */
	private function checkRequestMethod($element)
	{
		if($method = $element->getAnnotation('method')) {
			if (Strings::upper($method) !== $this->getHttpRequest()->getMethod()) {
				throw new ForbiddenRequestException('Bad HTTP method for the request.');
			}
		}
	}

}