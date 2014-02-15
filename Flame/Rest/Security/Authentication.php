<?php
/**
 * Class Authentication
 *
 * @author: Jiří Šifalda <sifalda.jiri@gmail.com>
 * @date: 26.10.13
 */
namespace Flame\Rest\Security;

use Nette\InvalidStateException;
use Nette\Object;

class Authentication extends Object implements IAuthenticator
{

	/** @var  IAuthenticator[]|array */
	private $authenticators = array();

	/**
	 * @param IAuthenticator $authenticator
	 * @return $this
	 */
	public function addAuthenticator(IAuthenticator $authenticator)
	{
		$this->authenticators[spl_object_hash($authenticator)] = $authenticator;
		return $this;
	}

	/**
	 * @param IAuthenticator $authenticator
	 * @return $this
	 */
	public function removeAuthenticator(IAuthenticator $authenticator)
	{
		$hash = spl_object_hash($authenticator);
		if (isset($this->authenticators[$hash])) {
			unset($this->authenticators[$hash]);
		}

		return $this;
	}

	/**
	 * @return void
	 * @throws \Nette\InvalidStateException
	 */
	public function authenticate()
	{
		if (count($this->authenticators)) {
			foreach($this->authenticators as $authenticator) {
				$authenticator->authenticate();
			}
		}else{
			throw new InvalidStateException('Missing authenticator.');
		}
	}
} 