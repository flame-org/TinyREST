<?php
/**
 * Class IClientTokenFactory
 *
 * @author Jiří Šifalda <sifalda.jiri@gmail.com>
 * @date 21.02.14
 */
namespace Flame\Rest\Security\Tokens;

interface IClientTokenFactory 
{

	/**
	 * @param string|\DateTime $expiration
	 * @return $this
	 */
	public function setExpiration($expiration);

	/**
	 * @param string $password
	 * @param string $userSalt
	 * @return ClientToken
	 */
	public function createClientToken($password, $userSalt);
} 