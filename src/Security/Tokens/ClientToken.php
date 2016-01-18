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

	/** @var  ServerToken */
	private $serverToken;

	/** @var string  */
	private $expiration;

	/** @var string */
	private $randomSalt;

	/**
	 * @param ServerToken $serverToken
	 * @param $expiration
	 * @param null $randomSalt
	 */
	function __construct(ServerToken $serverToken, $expiration, $randomSalt = null)
	{
		$this->serverToken = $serverToken;
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
		return base64_encode(implode(self::SEPARATOR, array($this->serverToken->encode(), $this->getExpiration(), $this->getRandomSalt())));
	}

	/**
	 * @return null|string
	 */
	public function getRandomSalt()
	{
		return $this->randomSalt;
	}

	/**
	 * @return \Flame\Rest\Security\Tokens\ServerToken
	 */
	public function getServerToken()
	{
		return $this->serverToken;
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