<?php
/**
 * Class HashAuthenticator
 *
 * @author: Jiří Šifalda <sifalda.jiri@gmail.com>
 * @date: 26.10.13
 */
namespace Flame\Rest\Security\Authenticators;

use Flame\Rest\Security\IHashStorage;
use Flame\Rest\Security\RequestTimeoutException;
use Flame\Rest\Security\IUserRepository;
use Flame\Rest\Security\IUser;
use Flame\Rest\Security\UnauthorizedRequestException;
use Nette\InvalidStateException;

class HashAuthenticator extends Authenticator
{

	/** @var IUser|null */
	private $user;

	/** @var \Flame\Rest\Security\IUserRepository  */
	private $authStorage;

	/** @var \Flame\Rest\Security\IHashStorage  */
	private $hashStorage;
	/**
	 * @param IUserRepository $authStorage
	 * @param IHashStorage $hashStorage
	 */
	function __construct(IUserRepository $authStorage, IHashStorage $hashStorage)
	{
		$this->authStorage = $authStorage;
		$this->hashStorage = $hashStorage;
	}

	/**
	 * @return IUser
	 * @throws \Nette\InvalidStateException
	 */
	protected function getUser()
	{
		if($this->user === null) {
			$this->user = $this->authStorage->findUserByHash($this->hashStorage->getUserHash()->getBasicTokenHash());
			if($this->user !== null && !$this->user instanceof IUser) {
				throw new InvalidStateException('User object must be instance of Flame\Rest\Security\IUser');
			}
		}

		return $this->user;
	}

	/**
	 * @return bool
	 * @throws \Flame\Rest\Security\UnauthorizedRequestException
	 */
	public function authRequestData()
	{
		if($this->isUserLogged() !== true) {
			throw new UnauthorizedRequestException('User is not logged.');
		}

		return true;
	}

	/**
	 * @return bool
	 * @throws \Flame\Rest\Security\RequestTimeoutException
	 */
	public function authRequestTimeout()
	{
		$expiration = $this->hashStorage->getUserHash()->getExpiration();
		if(!$expiration instanceof \DateTime || (new \DateTime()) > $expiration) {
			throw new RequestTimeoutException('Validity of token expired. Please sign in again.');
		}

		return true;
	}

	/**
	 * @return bool
	 */
	protected function isUserLogged()
	{
		return $this->getUser() instanceof IUser;
	}
}