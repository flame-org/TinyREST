<?php
/**
 * Class IHashStorage
 *
 * @author: Jiří Šifalda <sifalda.jiri@gmail.com>
 * @date: 27.10.13
 */

namespace Flame\Rest\Security;

use Flame\Rest\Security\Tokens\HashToken;

interface IHashStorage
{

	/**
	 * @return HashToken
	 */
	public function getUserHash();
} 