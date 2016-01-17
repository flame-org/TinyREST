<?php
/**
 * Class Token
 *
 * @author Jiří Šifalda <sifalda.jiri@gmail.com>
 * @date 21.02.14
 */
namespace Flame\Rest\Security\Tokens;

use Flame\Rest\Security\IToken;
use Nette\Object;

abstract class Token extends Object implements IToken
{

	/**
	 * @param string $token
	 * @return bool
	 */
	public function isEqualTo($token)
	{
		return $token === $this->encode();
	}

	/**
	 * @return string
	 */
	public function __toString()
	{
		return (string) $this->encode();
	}
} 