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

namespace FlameTests\Rest\DI;

use Nette\DI\Container;
use Tester\TestCase;
use Tester\Assert;

require_once __DIR__ . '/../../bootstrap.php';

/**
 * Class RestExtensionTest
 * @package FlameTests\Rest\DI
 */
class RestExtensionTest extends TestCase
{
	/** @var Container */
	private $container;

	protected function setUp()
	{
		$this->container = getContainer();
	}

	/**
	 * @param string $type
	 * @dataProvider provideServicesData
	 */
	public function testServices($type)
	{
		Assert::type($type, $this->container->getByType($type));
	}

	/**
	 * @return array
	 */
	public function provideServicesData()
	{
		return [
			['Flame\Rest\ResourceFactory'],
			['Flame\Rest\Request\ParametersFactory'],
			['Flame\Rest\Security\Storage\AuthorizationHash'],
			['Flame\Rest\Security\User'],
			['Flame\Rest\Security\Tokens\BasicTokenFactory'],
			['Flame\Rest\Security\Tokens\ServerTokenFactory'],
			['Flame\Rest\Security\Tokens\ClientTokenFactory'],
			['Flame\Rest\Security\Cors'],
		];
	}
}

run(new RestExtensionTest());
