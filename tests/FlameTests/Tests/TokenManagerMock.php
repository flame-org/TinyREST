<?php
/**
 * This file is part of the TinyREST package.
 *
 * (c) Ondřej Záruba <zarubaondra@gmail.com>
 *
 * For the full copyright and license information, please view the license.md
 * file that was distributed with this source code.
 */

namespace FlameTests\Tests;

use Flame\Rest\Security\Tokens\IToken;
use Flame\Rest\Security\Tokens\ITokenManager;

/**
 * Class TokenManagerMock
 * @package FlameTests\Tests
 */
class TokenManagerMock implements ITokenManager
{
	const VALID_VALUE = 'valid';

	const VALID_IDENTITY = ['item' => 'value'];

	public function isTokenValid(IToken $token)
	{
		return $token->getToken() === self::VALID_VALUE;
	}

	public function getIdentity(IToken $token)
	{
		return self::VALID_IDENTITY;
	}
}
