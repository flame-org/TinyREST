<?php
/**
 * Class NullAuthenticator
 *
 * @author Jiří Šifalda <sifalda.jiri@gmail.com>
 * @date 06.02.14
 */
namespace Flame\Rest\Security\Authenticators;

use Nette\Object;
use Flame\Rest\Security\IAuthenticator;

class NullAuthenticator extends Object implements IAuthenticator
{

	/**
	 * @return void
	 */
	public function authenticate()
	{
		return true;
	}
}