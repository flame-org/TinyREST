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
use Flame\Rest\Security\Tokens\ITokenGetter;
use Nette\Http\Request;

/**
 * Class TokenGetterMock
 * @package FlameTests\Tests
 */
class TokenGetterMock implements ITokenGetter
{
	public function getToken(Request $request)
	{
		$token = $request->getHeader('Authorization');

		return new AuthorizationToken($token);
	}
}
