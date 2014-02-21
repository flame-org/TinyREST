<?php
/**
 * Class AuthorizationHashStorage
 *
 * @author: Jiří Šifalda <sifalda.jiri@gmail.com>
 * @date: 27.10.13
 */
namespace Flame\Rest\Security\Storage;

use Flame\Rest\Security\IHashStorage;
use Flame\Rest\Security\Tokens\HashToken;
use Nette\Diagnostics\Debugger;
use Nette\Object;
use Flame\Rest\Security\UnauthorizedRequestException;

class AuthorizationHash extends Object implements IHashStorage
{

	/** @var HashToken  */
	private $hash;

	/**
	 * @return HashToken
	 * @throws \Flame\Rest\Security\UnauthorizedRequestException
	 */
	public function getUserHash()
	{
		if($this->hash === null) {
			if(!isset($_SERVER['HTTP_AUTHORIZATION'])) {
				Debugger::log('Missing HTTP header Authorization', Debugger::DETECT);
				throw new UnauthorizedRequestException;
			}

			$this->hash = $this->parseHeader($_SERVER['HTTP_AUTHORIZATION']);
		}

		return $this->hash;
	}

	/**
	 * @param $header
	 * @return HashToken
	 */
	protected function parseHeader($header)
	{
		return new HashToken(substr($header, 6));
	}
} 