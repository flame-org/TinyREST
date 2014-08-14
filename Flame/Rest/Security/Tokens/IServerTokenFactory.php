<?php
/**
 * @author: Jiří Šifalda <sifalda.jiri@gmail.com>
 */
namespace Flame\Rest\Security\Tokens;

interface IServerTokenFactory 
{

	/**
	 * @param string $password
	 * @param string $userSalt
	 * @return ServerToken
	 */
	public function createServerToken($password, $userSalt);
} 