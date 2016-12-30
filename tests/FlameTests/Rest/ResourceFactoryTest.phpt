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

namespace FlameTests\Rest;

use Flame\Rest\ResourceFactory;
use Tester\TestCase;
use Tester\Assert;

require_once __DIR__ . '/../bootstrap.php';

/**
 * Class ResourceFactoryTest
 * @package FlameTests\Rest
 */
class ResourceFactoryTest extends TestCase
{
	public function testCreate()
	{
		$factory = new ResourceFactory();
		Assert::type('Flame\Rest\Resource', $factory->create());
	}
}

run(new ResourceFactoryTest());
