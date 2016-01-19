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

use Flame\Rest\Resource;
use Tester\TestCase;
use Tester\Assert;

require_once __DIR__ . '/../bootstrap.php';

/**
 * Class ResourceTest
 * @package FlameTests\Rest
 */
class ResourceTest extends TestCase
{
	public function testData()
	{
		$resource = new Resource();
		$resource->data = ['item' => 'value'];
		Assert::same(['item' => 'value'], $resource->getData());
	}
}

run(new ResourceTest());
