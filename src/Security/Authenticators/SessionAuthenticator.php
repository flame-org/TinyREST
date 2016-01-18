<?php
/**
 * Class SessionAuthenticator
 *
 * @author: Jiří Šifalda <sifalda.jiri@gmail.com>
 * @date: 26.10.13
 */
namespace Flame\Rest\Security\Authenticators;

use Flame\Rest\Security\ForbiddenRequestException;
use Flame\Rest\Security\IAuthenticator;
use Nette\Object;
use Nette\Reflection\Method;
use Nette\Security\User;

class SessionAuthenticator extends Object implements IAuthenticator
{

	/** @var  User */
	private $user;

	/**
	 * @param User $user
	 */
	function __construct(User $user)
	{
		$this->user = $user;
	}

	/**
	 * @param Method $element
	 * @throws \Flame\Rest\Security\ForbiddenRequestException
	 */
	public function authenticate(Method $element)
	{
		$user = (array) $element->getAnnotation('User');
		if (in_array('loggedIn', $user)) {
			if (!$this->user->isLoggedIn()) {
				throw new ForbiddenRequestException('Please sign in.');
			}
		}
	}
}