<?php
/**
 * Class IpAuthenticator
 *
 * @author Jiří Šifalda <sifalda.jiri@gmail.com>
 * @date 15.02.14
 */
namespace Flame\Rest\Security\Authenticators;

use Flame\Rest\Security\ForbiddenRequestException;
use Flame\Rest\Security\IAuthenticator;
use Nette\Object;

class IpAuthenticator extends Object implements IAuthenticator
{

	/** @var  array */
	private $allowedIps;

	/**
	 * @param array $allowedIps
	 */
	function __construct(array $allowedIps)
	{
		$this->allowedIps = $allowedIps;
	}

	/**
	 * @throws \Flame\Rest\Security\ForbiddenRequestException
	 */
	public function authenticate()
	{
		if (!in_array($this->getClientIp(), $this->allowedIps)) {
			throw new ForbiddenRequestException;
		}
	}

	/**
	 * @return mixed
	 */
	protected function getClientIp()
	{
		if (isset($_SERVER['REMOTE_ADDR'])) {
			return $_SERVER['REMOTE_ADDR'];
		}
	}
}