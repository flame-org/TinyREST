<?php
/**
 * Class BasicTokenFactory
 *
 * @author Jiří Šifalda <sifalda.jiri@gmail.com>
 * @date 21.02.14
 */
namespace Flame\Rest\Security\Tokens;

use Nette\Object;

class BasicTokenFactory extends Object implements IBasicTokenFactory
{

	/** @var  string */
	private $systemSalt;

	/**
	 * @param $systemSalt
	 */
	function __construct($systemSalt)
	{
		$this->systemSalt = (string) $systemSalt;
	}

	/**
	 * @param string $password
	 * @param string $userSalt
	 * @return BasicToken
	 */
	public function createBasicToken($password, $userSalt)
	{
		return new BasicToken($password, $this->systemSalt, $userSalt);
	}
}