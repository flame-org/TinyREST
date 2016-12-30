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

namespace FlameTests\Rest\Security\Authenticators;

use Flame\Rest\Security\Authenticators\IpAuthenticator;
use Tester\TestCase;
use Tester\Assert;
use Tracy\Debugger;

require_once __DIR__ . '/../../../bootstrap.php';

/**
 * Class IpAuthenticatorTest
 * @package FlameTests\Rest\Security\Authenticators
 */
class IpAuthenticatorTest extends TestCase
{
	/** @var IpAuthenticator */
	private $authenticator;

	protected function setUp()
	{
		$this->authenticator = new IpAuthenticator(['127.0.0.1']);
	}

	public function testAuthenticate()
	{
		$_SERVER['REMOTE_ADDR'] = '127.0.0.1';
		Debugger::$logDirectory = TEMP_DIR;
		Assert::noError(function () {
			$this->authenticator->authenticate(\Mockery::mock('Nette\Reflection\Method'));
		});
	}

	public function testAuthenticateError()
	{
		$_SERVER['REMOTE_ADDR'] = '192.168.0.1';
		Debugger::$logDirectory = TEMP_DIR;
		Assert::exception(function () {
			$this->authenticator->authenticate(\Mockery::mock('Nette\Reflection\Method'));
		}, 'Flame\Rest\Security\ForbiddenRequestException');
	}
}

run(new IpAuthenticatorTest());
