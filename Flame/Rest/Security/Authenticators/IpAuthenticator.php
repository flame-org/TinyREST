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
			throw new ForbiddenRequestException('Banned ip.');
		}
	}

	/**
	 * @return mixed
	 */
	protected function getClientIp()
	{
		foreach (array('HTTP_CLIENT_IP', 'HTTP_X_FORWARDED_FOR', 'HTTP_X_FORWARDED', 'HTTP_X_CLUSTER_CLIENT_IP', 'HTTP_FORWARDED_FOR', 'HTTP_FORWARDED', 'REMOTE_ADDR') as $key) {
			if (array_key_exists($key, $_SERVER) === true) {
				foreach (explode(',', $_SERVER[$key]) as $ip) {
					if (filter_var($ip, FILTER_VALIDATE_IP) !== false) {
						return $ip;
					}
				}
			}
		}
	}
}