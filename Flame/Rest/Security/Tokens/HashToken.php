<?php
/**
 * Class HashToken
 *
 * @author Jiří Šifalda <sifalda.jiri@gmail.com>
 * @date 21.02.14
 */
namespace Flame\Rest\Security\Tokens;

class HashToken extends Token
{

	/** @var  string */
	private $hash;

	/** @var  string|null */
	private $randomSalt;

	/** @var  \Datetime|null */
	private $expiration;

	/** @var  string|null */
	private $basicTokenHash;

	/**
	 * @param $hash
	 */
	function __construct($hash)
	{
		$this->decode($hash);
	}

	/**
	 * @return string
	 */
	public function encode()
	{
		return $this->hash;
	}

	/**
	 * @param $token
	 */
	private function decode($token)
	{
		$this->hash = (string) $token;
		$token = base64_decode($this->hash);
		$pieces = explode(self::SEPARATOR, $token);

		$this->basicTokenHash = (isset($pieces[0])) ? $pieces[0] : null;
		$this->randomSalt = (isset($pieces[2])) ? $pieces[2] : null;

		if (isset($pieces[1])) {
			$expiration = new \DateTime('- 1 day');
			$expiration->setTimestamp($pieces[1]);
			$this->expiration = $expiration;
		}
	}

	/**
	 * @return string
	 */
	public function getBasicTokenHash()
	{
		return $this->basicTokenHash;
	}

	/**
	 * @return \Datetime
	 */
	public function getExpiration()
	{

		return $this->expiration;
	}

	/**
	 * @return string
	 */
	public function getRandomSalt()
	{
		return $this->randomSalt;
	}

} 