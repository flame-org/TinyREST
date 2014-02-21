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
	function __construct(IUserRepository $userRepository, IHashStorage $hashStorage)
	{
		$this->userRepository = $userRepository;
		$this->hashStorage = $hashStorage;
	}

	/**
	 * @return bool
	 */
	public function isLoggedIn()
	{
		return $this->getUserEntity() instanceof IUserEntity && $this->isValidExpirationTime();
	}

	/**
	 * @return IUser|null
	 * @throws \Nette\InvalidStateException
	 */
	public function getUserEntity()
	{
		if($this->entity === null) {
			$this->entity = $this->userRepository->findUserByHash($this->hashStorage->getUserHash()->getBasicTokenHash());
			if($this->entity !== null && !$this->entity instanceof IUserEntity) {
				throw new InvalidStateException('User object must be instance of Flame\Rest\Security\IUserEntity');
			}
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