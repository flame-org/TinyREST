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

use Flame\Rest\Security\Authenticators\RefererAuthenticator;
use Tester\TestCase;
use Tester\Assert;
use Tracy\Debugger;

require_once __DIR__ . '/../../../bootstrap.php';

/**
 * Class RefererAuthenticatorTest
 * @package FlameTests\Rest\Security\Authenticators
 */
class RefererAuthenticatorTest extends TestCase
{
	/** @var RefererAuthenticator */
	private $authenticator;

	protected function setUp()
	{
		$this->authenticator = new RefererAuthenticator(['http://www.w3.org/hypertext/DataSources/Overview.html']);
	}

	public function testAuthenticate()
	{
		$_SERVER['HTTP_REFERER'] = 'http://www.w3.org/hypertext/DataSources/Overview.html';
		Debugger::$logDirectory = TEMP_DIR;
		Assert::noError(function () {
			$this->authenticator->authenticate(\Mockery::mock('Nette\Reflection\Method'));
		});
	}

	public function testAuthenticateError()
	{
		$_SERVER['HTTP_REFERER'] = 'http://www.google.org/';
		Debugger::$logDirectory = TEMP_DIR;
		Assert::exception(function () {
			$this->authenticator->authenticate(\Mockery::mock('Nette\Reflection\Method'));
		}, 'Flame\Rest\Security\ForbiddenRequestException');
	}
}

run(new RefererAuthenticatorTest());
