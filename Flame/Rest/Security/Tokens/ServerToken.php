<?php
/**
 * @author: Jiří Šifalda <sifalda.jiri@gmail.com>
 */
namespace Flame\Rest\Security\Tokens;

use Nette\Utils\Strings;

class ServerToken extends Token
{

	/** @var  BasicToken */
	private $basicToken;

	/** @var  string */
	private $randomSuffix;

	/**
	 * @param BasicToken $basicToken
	 */
	function __construct(BasicToken $basicToken)
	{
		$this->basicToken = $basicToken;

		$this->randomSuffix = Strings::random(5);
	}

	/**
	 * @return string
	 */
	public function encode()
	{
		return sha1(implode(self::SEPARATOR, array($this->basicToken->encode(), $this->randomSuffix)));
	}
}