<?php
/**
 * Class IAuthenticator
 *
 * @author: Jiří Šifalda <sifalda.jiri@gmail.com>
 * @date: 26.10.13
 */

namespace Flame\Rest\Security;

use Nette\Reflection\Method;

interface IAuthenticator
{

	/**
	 * @param Method $element
	 * @return void
	 */
	public function authenticate(Method $element);
} 