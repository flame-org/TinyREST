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

namespace FlameTests\Rest\Request;

use Flame\Rest\Request\ParametersFactory;
use Tester\Assert;
use Tester\TestCase;

require_once __DIR__ . '/../../bootstrap.php';

/**
 * Class ParametersFactoryTest
 * @package FlameTests\Rest\Request
 */
class ParametersFactoryTest extends TestCase
{
	public function testCreateWithJson()
	{
		$data = ['item' => 'value'];
		$httpRequest = \Mockery::mock('Nette\Http\Request');
		$httpRequest->shouldReceive('getPost')->andReturn(json_encode($data));
		$factory = new ParametersFactory($httpRequest);
		Assert::equal($data, $factory->create()->getData());
	}

	public function testCreateWithoutJson()
	{
		$data = ['item' => 'value'];
		$httpRequest = \Mockery::mock('Nette\Http\Request');
		$httpRequest->shouldReceive('getPost')->andReturn($data);
		$factory = new ParametersFactory($httpRequest);
		Assert::equal($data, $factory->create()->getData());
	}
}

run(new ParametersFactoryTest());
