<?php
/**
 * Class ClientToken
 *
 * @author Jiří Šifalda <sifalda.jiri@gmail.com>
 * @date 21.02.14
 */
namespace Flame\Rest\Security\Tokens;

use Nette\Utils\Strings;

class ClientToken extends Token
{

	/** @var  BasicToken */
	private $basicToken;

	/** @var string  */
	private $expiration;

	/** @var string */
	private $randomSalt;

	/**
	 * @param BasicToken $basicToken
	 * @param $expiration
	 * @param null $randomSalt
	 */
	function __construct(BasicToken $basicToken, $expiration, $randomSalt = null)
	{
		$this->basicToken = $basicToken;
		$this->expiration = (string) $expiration;

		if ($randomSalt === null) {
			$randomSalt = Strings::random(5);
		}

		$this->randomSalt = $randomSalt;
	}

	/**
	 * @return string
	 */
	public function encode()
	{
		return base64_encode(implode(self::SEPARATOR, array($this->basicToken->encode(), $this->getExpiration(), $this->getRandomSalt())));
	}

	/**
	 * @return null|string
	 */
	public function getRandomSalt()
	{
		return $this->randomSalt;
	}

	/**
	 * @return \Flame\Rest\Security\Tokens\BasicToken
	 */
	public function getBasicToken()
	{
		return $this->basicToken;
	}

	/**
	 * @return int
	 */
	public function getExpiration()
	{
		if (!$this->expiration instanceof \DateTime) {
			$this->expiration = new \DateTime($this->expiration);
		}

		return $this->expiration->getTimestamp();
	}
}