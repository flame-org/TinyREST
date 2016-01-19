<?php
/**
 * Class User
 *
 * @author Jiří Šifalda <sifalda.jiri@gmail.com>
 * @date 21.02.14
 */
namespace Flame\Rest\Security;

use Flame\Rest\Security\Tokens\ITokenGetter;
use Flame\Rest\Security\Tokens\ITokenManager;
use Nette\Http\Request;
use Nette\InvalidStateException;
use Nette\Object;

/**
 * Class User
 * @package Flame\Rest\Security
 */
class User extends Object implements IUser
{
	/** @var mixed */
	private $identity = null;

	/** @var ITokenGetter */
	private $tokenGetter;

	/** @var ITokenManager */
	private $tokenManager;

	/** @var Request */
	private $request;

	/**
	 * User constructor.
	 * @param ITokenGetter $tokenGetter
	 * @param ITokenManager $tokenManager
	 * @param Request $request
	 */
	function __construct(ITokenGetter $tokenGetter, ITokenManager $tokenManager, Request $request)
	{
		$this->tokenGetter = $tokenGetter;
		$this->tokenManager = $tokenManager;
		$this->request = $request;
	}

	/**
	 * @return ITokenManager
	 */
	public function getTokenManager()
	{
		if ($this->tokenManager === null) {
			throw new InvalidStateException('Please add service which implement \Flame\Rest\Security\Tokens\ITokenManager into your DIC.');
		}

		return $this->tokenManager;
	}

	/**
	 * @return ITokenGetter
	 */
	public function getTokenGetter()
	{
		if ($this->tokenGetter === null) {
			throw new InvalidStateException('Please add service which implement \Flame\Rest\Security\Tokens\ITokenGetter into your DIC.');
		}

		return $this->tokenGetter;
	}

	/**
	 * @return bool
	 */
	public function isLoggedIn()
	{
		$token = $this->getTokenGetter()->getToken($this->request);

		return $this->getTokenManager()->isTokenValid($token);
	}

	/**
	 * @return bool|mixed
	 */
	public function getIdentity()
	{
		if ($this->isLoggedIn()) {
			$token = $this->getTokenGetter()->getToken($this->request);
			$this->identity = $this->getTokenManager()->getIdentity($token);
		}

		return $this->identity;
	}
}
