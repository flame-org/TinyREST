<?php
/**
 * Class BasicAuthenticator
 *
 * @author: Jiří Šifalda <sifalda.jiri@gmail.com>
 * @date: 26.10.13
 */
namespace Flame\Rest\Security\Authenticators;

use Flame\Rest\Request\Parameters;
use Flame\Rest\Security\AuthenticationException;
use Flame\Rest\Security\UnauthorizedRequestException;
use Nette\Security\User;
use Nette\Security\IUserStorage;

class BasicAuthenticator extends Authenticator
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
	 * @param Parameters $params
	 * @return bool|void
	 * @throws \Flame\Rest\Security\UnauthorizedRequestException
	 */
	public function authRequestData(Parameters $params)
	{
		if (!$this->user->isLoggedIn()) {
			throw new UnauthorizedRequestException('User is not logged.');
		}
	}

	/**
	 * @param Parameters $params
	 * @return bool|void
	 * @throws \Flame\Rest\Security\AuthenticationException
	 */
	public function authRequestTimeout(Parameters $params)
	{
		if ($this->user->getLogoutReason() === IUserStorage::INACTIVITY) {
			throw new AuthenticationException('User session expired');
		}
	}
}