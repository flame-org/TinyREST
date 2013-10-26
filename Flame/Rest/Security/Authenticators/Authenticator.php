<?php
/**
 * Class Authenticator
 *
 * @author: Jiří Šifalda <sifalda.jiri@gmail.com>
 * @date: 26.10.13
 */
namespace Flame\Rest\Security\Authenticators;

use Flame\Rest\Request\Parameters;
use Flame\Rest\Security\IAuthenticator;
use Nette\Object;

abstract class Authenticator extends Object implements IAuthenticator
{

	/**
	 * @param Parameters $params
	 * @return bool
	 */
	public function authenticate(Parameters $params)
	{
		$this->authRequestData($params);
		$this->authRequestTimeout($params);
		return true;
	}

	/**
	 * @param Parameters $params
	 * @return bool
	 */
	abstract public function authRequestData(Parameters $params);

	/**
	 * @param Parameters $params
	 * @return bool
	 */
	abstract public function authRequestTimeout(Parameters $params);
} 