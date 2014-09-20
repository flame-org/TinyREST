<?php
/**
 * Class User
 *
 * @author Jiří Šifalda <sifalda.jiri@gmail.com>
 * @date 21.02.14
 */
namespace Flame\Rest\Security;

use Nette\InvalidStateException;
use Nette\Object;

class User extends Object implements IUser
{

	/** @var  IUser|null */
	private $entity;

	/** @var \Flame\Rest\Security\IUserRepository  */
	private $userRepository;

	/** @var \Flame\Rest\Security\IHashStorage  */
	private $hashStorage;

	/**
	 * @param IUserRepository $userRepository
	 * @param IHashStorage $hashStorage
	 */
	function __construct(IHashStorage $hashStorage, IUserRepository $userRepository = null)
	{
		$this->userRepository = $userRepository;
		$this->hashStorage = $hashStorage;
	}

	/**
	 * @return IUserRepository
	 * @throws \Nette\InvalidStateException
	 */
	public function getUserRepository()
	{
		if ($this->userRepository === null) {
			throw new InvalidStateException('Please add service which implement \Flame\Rest\Security\IUserRepository into your DIC.');
		}

		return $this->userRepository;
	}

	/**
	 * @return bool
	 */
	public function isLoggedIn()
	{
		$hash = $this->hashStorage->getUserHash();

		if($hash) {
			$user = $this->getUserRepository()->findUserByHash($hash->getBasicTokenHash());
		}else{
			$user = null;
		}

		return $user instanceof IUserEntity && $this->isValidExpirationTime();
	}

	/**
	 * @return IUser|null
	 * @throws \Nette\InvalidStateException
	 */
	public function getUserEntity()
	{
		if($this->isLoggedIn() && $this->entity === null) {
			$this->entity = $this->getUserRepository()->getIdentity();
		}

		return $this->entity;
	}

	/**
	 * @return bool
	 */
	protected function isValidExpirationTime()
	{
		$expiration = $this->hashStorage->getUserHash()->getExpiration();
		if(!$expiration instanceof \DateTime || (new \DateTime()) > $expiration) {
			return false;
		}

		return true;
	}
}