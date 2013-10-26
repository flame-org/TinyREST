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
	protected $checkRequestMethod = false;

	/** @var  \Flame\Rest\Security\Authentication */
	protected $authentication;

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

		} catch (ForbiddenRequestException $ex) {
			$this->sendErrorResource($ex);
		}
	}

	/**
	 * @return void
	 */
	protected function startup()
	{
		parent::startup();

		$this->authentication = $this->context->getByType('Flame\Rest\Security\Authentication');
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