<?php
/**
 * This file is part of the TinyREST package.
 *
 * (c) Ondřej Záruba <zarubaondra@gmail.com>
 *
 * For the full copyright and license information, please view the license.md
 * file that was distributed with this source code.
 *
 * @testCase
 */

namespace FlameTests\Rest\Security;

use Flame\Rest\Security\User;
use FlameTests\Tests\TokenGetterMock;
use FlameTests\Tests\TokenManagerMock;
use Nette\Http\Request;
use Tester\TestCase;
use Tester\Assert;

require_once __DIR__ . '/../../bootstrap.php';

/**
 * Class UserTest
 * @package FlameTests\Rest\Security
 */
class UserTest extends TestCase
{
	/** @var Request */
	private $validRequest;

	/** @var Request */
	private $invalidRequest;

	protected function setUp()
	{
		$this->validRequest = \Mockery::mock('Nette\Http\Request');
		$this->validRequest->shouldReceive('getHeader')->withArgs(['Authorization'])->andReturn(TokenManagerMock::VALID_VALUE);
		$this->invalidRequest = \Mockery::mock('Nette\Http\Request');
		$this->invalidRequest->shouldReceive('getHeader')->withArgs(['Authorization'])->andReturn('invalid');
	}

	public function testIsLoggedIn()
	{
		$user = new User(new TokenGetterMock(), new TokenManagerMock(), $this->validRequest);
		$invalidUser = new User(new TokenGetterMock(), new TokenManagerMock(), $this->invalidRequest);
		Assert::true($user->isLoggedIn());
		Assert::false($invalidUser->isLoggedIn());
	}

	public function testGetIdentity()
	{
		$user = new User(new TokenGetterMock(), new TokenManagerMock(), $this->validRequest);
		$invalidUser = new User(new TokenGetterMock(), new TokenManagerMock(), $this->invalidRequest);
		Assert::equal(TokenManagerMock::VALID_IDENTITY, $user->getIdentity());
		Assert::null($invalidUser->getIdentity());
	}
}

run(new UserTest());
