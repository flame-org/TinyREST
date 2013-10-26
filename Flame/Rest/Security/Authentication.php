<?php
/**
 * Class Authentication
 *
 * @author: Jiří Šifalda <sifalda.jiri@gmail.com>
 * @date: 26.10.13
 */
namespace Flame\Rest\Security;

use Flame\Rest\Request\Parameters;
use Flame\Rest\Security\Authenticators\BasicAuthenticator;
use Nette\Object;

class Authentication extends Object
{

	/** @var  IAuthenticator */
	private $authenticator;

	/**
	 * @param BasicAuthenticator $authenticator
	 */
	function __construct(BasicAuthenticator $authenticator = null)
	{
		$this->authenticator = $authenticator;
	}

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
	 * @param Parameters $params
	 * @return bool
	 * @throws \Nette\InvalidStateException
	 */
	public function authenticate(Parameters $params)
	{
		if($this->authenticator !== null) {
			return $this->authenticator->authenticate($params);
		}

		return true;
	}

} 