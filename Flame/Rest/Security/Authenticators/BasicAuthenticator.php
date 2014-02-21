<?php
/**
 * Class BasicAuthenticator
 *
 * @author Jiří Šifalda <sifalda.jiri@gmail.com>
 * @date 21.02.14
 */
namespace Flame\Rest\Security\Authenticators;

use Flame\Rest\Security\ForbiddenRequestException;
use Flame\Rest\Security\IAuthenticator;
use Flame\Rest\Security\IUser;
use Nette\Object;

class BasicAuthenticator extends Object implements IAuthenticator
{

	/** @var  IUser */
	private $user;

	/**
	 * @param IUser $user
	 */
	function __construct(IUser $user)
	{
		$this->user = $user;
	}

	/**
	 * @throws \Flame\Rest\Security\ForbiddenRequestException
	 */
	public function authenticate()
	{
		if (!$this->user->isLoggedIn()) {
			throw new ForbiddenRequestException('Please sign in.');
		}
	}
}