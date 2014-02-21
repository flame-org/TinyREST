<?php
/**
 * Class SessionAuthenticator
 *
 * @author: Jiří Šifalda <sifalda.jiri@gmail.com>
 * @date: 26.10.13
 */
namespace Flame\Rest\Security\Authenticators;

use Flame\Rest\Security\AuthenticationException;
use Flame\Rest\Security\UnauthorizedRequestException;
use Nette\Security\User;
use Nette\Security\IUserStorage;

class SessionAuthenticator extends Authenticator
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
	 * @return bool
	 * @throws \Flame\Rest\Security\UnauthorizedRequestException
	 */
	public function authRequestData()
	{
		if (!$this->user->isLoggedIn()) {
			throw new UnauthorizedRequestException('User is not logged.');
		}

		return true;
	}

	/**
	 * @return bool
	 * @throws \Flame\Rest\Security\AuthenticationException
	 */
	public function authRequestTimeout()
	{
		if ($this->user->getLogoutReason() === IUserStorage::INACTIVITY) {
			throw new AuthenticationException('User session expired');
		}

		return true;
	}
}