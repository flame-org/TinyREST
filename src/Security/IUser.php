<?php
/**
 * Class IUser
 *
 * @author Jiří Šifalda <sifalda.jiri@gmail.com>
 * @date 21.02.14
 */
namespace Flame\Rest\Security;

interface IUser
{

	/**
	 * @return bool
	 */
	public function isLoggedIn();

	/**
	 * @return false|
	 */
	public function getIdentity();
}
