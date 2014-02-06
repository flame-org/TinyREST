<?php
/**
 * Class NullAuthenticator
 *
 * @author Jiří Šifalda <sifalda.jiri@gmail.com>
 * @date 06.02.14
 */
namespace Flame\Rest\Security\Authenticators;

class NullAuthenticator extends Authenticator
{

	/**
	 * @return bool
	 */
	public function authRequestData()
	{
		return true;
	}

	/**
	 * @return bool
	 */
	public function authRequestTimeout()
	{
		return true;
	}
}