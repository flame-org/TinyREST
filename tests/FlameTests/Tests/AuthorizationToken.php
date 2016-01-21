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

/**
 * Class AuthorizationToken
 * @package FlameTests\Tests
 */
class AuthorizationToken implements IToken
{
	private $token;

	public function __construct($token)
	{
		$this->token = $token;
	}

	public function getToken()
	{
		return $this->token;
	}
}
