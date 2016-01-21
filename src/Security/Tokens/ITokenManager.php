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
 * Interface ITokenValidator
 * @package Flame\Rest\Security\Tokens
 */
interface ITokenManager
{
	/**
	 * @param IToken $token
	 * @return bool
	 */
	public function isTokenValid(IToken $token);

	/**
	 * Returns any identity format or false if is token invalid
	 *
	 * @param IToken $token
	 * @return mixed|bool
	 */
	public function getIdentity(IToken $token);
}
