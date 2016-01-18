<?php
/**
 * @author: Jiří Šifalda <sifalda.jiri@gmail.com>
 */
namespace Flame\Rest\Security\Tokens;

use Nette\Object;

class ServerTokenFactory extends Object implements IServerTokenFactory
{

	/** @var  IBasicTokenFactory */
	private $basicTokenFactory;

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
	 * @return ServerToken
	 */
	public function createServerToken($password, $userSalt)
	{
		return new ServerToken($this->basicTokenFactory->createBasicToken($password, $userSalt));
	}


}