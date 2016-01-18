<?php
/**
 * Class BasicToken
 *
 * @author Jiří Šifalda <sifalda.jiri@gmail.com>
 * @date 21.02.14
 */
namespace Flame\Rest\Security\Tokens;

class BasicToken extends Token
{

	/** @var  string */
	private $systemSalt;

	/** @var  string */
	private $userSalt;

	/** @var  string */
	private $password;

	/**
	 * @param $password
	 * @param $systemSalt
	 * @param $userSalt
	 */
	function __construct($password, $systemSalt, $userSalt)
	{
		$this->password = (string) $password;
		$this->systemSalt = (string) $systemSalt;
		$this->userSalt = (string) $userSalt;
	}

	/**
	 * @return string
	 */
	public function encode()
	{
		return sha1(implode(self::SEPARATOR, array($this->password, $this->systemSalt, $this->userSalt)));
	}
}