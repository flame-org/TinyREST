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

	/**
	 * @param string $key
	 * @return string
	 */
	public function calculate($key)
	{
		return hash_hmac(self::HASH, (string) $key, Strings::random());
	}

} 