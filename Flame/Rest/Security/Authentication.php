<?php
/**
 * Class Authentication
 *
 * @author: Jiří Šifalda <sifalda.jiri@gmail.com>
 * @date: 26.10.13
 */
namespace Flame\Rest\Security;

use Nette\Object;

class Authentication extends Object implements IAuthenticator
{

	/** @var  IAuthenticator */
	private $authenticator;

	/**
	 * @param IAuthenticator $authenticator
	 * @return $this
	 */
	public function setAuthenticator(IAuthenticator $authenticator)
	{
		$this->authenticator = $authenticator;
		return $this;
	}

	/**
	 * @return bool
	 */
	public function authenticate()
	{
		if($this->authenticator !== null) {
			return $this->authenticator->authenticate();
		}

		return true;
	}
} 