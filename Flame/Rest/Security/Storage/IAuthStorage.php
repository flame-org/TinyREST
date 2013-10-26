<?php
/**
 * Class IAuthStorage
 *
 * @author: Jiří Šifalda <sifalda.jiri@gmail.com>
 * @date: 26.10.13
 */
namespace Flame\Rest\Security\Storage;

use Flame\Rest\Security\IUser;

interface IAuthStorage
{

	/**
	 * @param $hash
	 * @return IUser
	 */
	public function findUserByHash($hash);
} 