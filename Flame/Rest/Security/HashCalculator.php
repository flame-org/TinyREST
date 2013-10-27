<?php
/**
 * Class HashCalculator
 *
 * @author: Jiří Šifalda <sifalda.jiri@gmail.com>
 * @date: 27.10.13
 */
namespace Flame\Rest\Security;

use Flame\Utils\Strings;
use Nette\Object;

class HashCalculator extends Object implements IHashCalculator
{

	/** hash algorithm */
	const HASH = 'sha256';

	/** @var  string */
	private $expiration;

	/**
	 * @param $expiration
	 */
	function __construct($expiration = '+ 30 days')
	{
		$this->expiration = (string) $expiration;
	}

	/**
	 * @param string $expiration
	 * @return $this
	 */
	public function setExpiration($expiration)
	{
		$this->expiration = (string) $expiration;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getExpiration()
	{
		return $this->expiration;
	}

	/**
	 * @param string $key
	 * @return string
	 */
	public function calculate($key)
	{
		$hash = hash_hmac(self::HASH, (string) $key, Strings::random());
		$expiration = new \DateTime($this->expiration);
		return $hash . ':' . $expiration->getTimestamp();
	}

} 