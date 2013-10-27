<?php
/**
 * Class IAuthenticator
 *
 * @author: Jiří Šifalda <sifalda.jiri@gmail.com>
 * @date: 26.10.13
 */

namespace Flame\Rest\Security;

interface IAuthenticator
{

	/**
	 * @return bool
	 */
	public function authenticate();
} 