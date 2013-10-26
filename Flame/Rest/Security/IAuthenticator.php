<?php
/**
 * Class IAuthenticator
 *
 * @author: Jiří Šifalda <sifalda.jiri@gmail.com>
 * @date: 26.10.13
 */

namespace Flame\Rest\Security;

use Flame\Rest\Request\Parameters;

interface IAuthenticator
{

	/**
	 * @param Parameters $params
	 * @return bool
	 */
	public function authenticate(Parameters $params);
} 