<?php
/**
 * Class IHashCalculator
 *
 * @author: Jiří Šifalda <sifalda.jiri@gmail.com>
 * @date: 27.10.13
 */
namespace Flame\Rest\Security;

interface IHashCalculator
{

	/**
	 * @param string $key
	 * @return string
	 */
	public function calculate($key);
} 