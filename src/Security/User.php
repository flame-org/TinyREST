<?php
/**
 * Class User
 *
 * @author Jiří Šifalda <sifalda.jiri@gmail.com>
 * @date 21.02.14
 */
namespace Flame\Rest\Security;

use Flame\Rest\Security\Tokens\ITokenManager;
use Flame\Rest\Security\Tokens\ITokenProvider;
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

	/** @var ITokenProvider */
	private $tokenProvider;

	/** @var ITokenManager */
	private $tokenManager;

	/** @var Request */
	private $request;

	/**
	 * User constructor.
	 * @param ITokenProvider $tokenProvider
	 * @param ITokenManager $tokenManager
	 * @param Request $request
	 */
	function __construct(ITokenProvider $tokenProvider, ITokenManager $tokenManager, Request $request)
	{
		$this->tokenProvider = $tokenProvider;
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
	 * @return ITokenProvider
	 */
	public function getTokenGetter()
	{
		if ($this->tokenProvider === null) {
			throw new InvalidStateException('Please add service which implement \Flame\Rest\Security\Tokens\ITokenGetter into your DIC.');
		}

		return $this->tokenProvider;
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
