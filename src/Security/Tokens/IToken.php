<?php
/**
 * This file is part of the TinyREST package.
 *
 * (c) Ondřej Záruba <zarubaondra@gmail.com>
 *
 * For the full copyright and license information, please view the license.md
 * file that was distributed with this source code.
 */

namespace Flame\Rest\Security\Tokens;

/**
 * Interface IToken
 * @package Flame\Rest\Security\Tokens
 */
interface IToken
{
	/**
	 * Returns token
	 *
	 * @return mixed
	 */
	public function getToken();
}
