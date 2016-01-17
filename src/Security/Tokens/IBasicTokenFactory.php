<?php
/**
 * Class IBasicTokenFactory
 *
 * @author Jiří Šifalda <sifalda.jiri@gmail.com>
 * @date 21.02.14
 */
namespace Flame\Rest\Security\Tokens;

interface IBasicTokenFactory 
{

	/**
	 * @param string $password
	 * @param string $userSalt
	 * @return BasicToken
	 */
	public function createBasicToken($password, $userSalt);
} 