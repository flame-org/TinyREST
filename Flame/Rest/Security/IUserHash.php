<?php
/**
 * Class IUserHash
 *
 * @author: Jiří Šifalda <sifalda.jiri@gmail.com>
 * @date: 27.10.13
 */

namespace Flame\Rest\Security;


interface IUserHash
{

	/**
	 * @return string
	 */
	public function getHash();
} 