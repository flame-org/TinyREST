<?php
/**
 * Class ClientTokenFactory
 *
 * @author Jiří Šifalda <sifalda.jiri@gmail.com>
 * @date 21.02.14
 */
namespace Flame\Rest\Security\Tokens;

use Nette\InvalidArgumentException;
use Nette\Object;

class ClientTokenFactory extends Object implements IClientTokenFactory
{

	/** @var  IBasicTokenFactory */
	private $basicTokenFactory;

	/** @var  string|\DateTime */
	private $expiration = '+ 14 days';

	/**
	 * @param IBasicTokenFactory $basicTokenFactory
	 */
	function __construct(IBasicTokenFactory $basicTokenFactory)
	{
		$this->basicTokenFactory = $basicTokenFactory;
	}

	/**
	 * @param string $password
	 * @param string $userSalt
	 * @return ClientToken
	 */
	public function createClientToken($password, $userSalt)
	{
		$basicToken = $this->basicTokenFactory->createBasicToken($password, $userSalt);
		return new ClientToken($basicToken, $this->expiration);
	}

	/**
	 * @param \DateTime|string $expiration
	 * @return $this
	 * @throws \Nette\InvalidArgumentException
	 */
	public function setExpiration($expiration)
	{
		if (!$expiration instanceof \DateTime && !is_string($expiration)) {
			throw new InvalidArgumentException('Invalid type "' . gettype($expiration) . ' given. Allowed are string and \DateTime');
		}

		if (!$expiration instanceof \DateTime) {
			$expiration = new \DateTime($expiration);
		}

		$this->expiration = $expiration;
		return $this;
	}
}