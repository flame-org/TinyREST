<?php
/**
 * Class IUserRepository
 *
 * @author: Jiří Šifalda <sifalda.jiri@gmail.com>
 * @date: 26.10.13
 */
namespace Flame\Rest\Security;

interface IUserRepository
{

	/**
	 * @param string $hash
	 * @return IUser
	 */
	public function findUserByHash($hash);

	/**
	 * @return mixed
	 */
	public function getIdentity();
} 
