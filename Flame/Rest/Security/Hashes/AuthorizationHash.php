<?php
/**
 * Class AuthorizationHash
 *
 * @author: Jiří Šifalda <sifalda.jiri@gmail.com>
 * @date: 27.10.13
 */
namespace Flame\Rest\Security\Hashes;

use Nette\Object;
use Flame\Rest\Security\IUserHash;
use Flame\Rest\Security\UnauthorizedRequestException;

class AuthorizationHash extends Object implements IUserHash
{

	/** @var  string */
	private $hash;

	/**
	 * @return string
	 * @throws UnauthorizedRequestException
	 */
	public function getHash()
	{
		if($this->hash === null) {
			if(!isset($_SERVER['HTTP_AUTHORIZATION'])) {
				throw new UnauthorizedRequestException('Missing HTTP header Authorization');
			}

			$this->hash = $this->parseHeader();
		}


		return $this->hash;
	}

	/**
	 * @return string
	 */
	protected function parseHeader()
	{
		return base64_decode(substr($_SERVER['HTTP_AUTHORIZATION'], 6));
	}
} 