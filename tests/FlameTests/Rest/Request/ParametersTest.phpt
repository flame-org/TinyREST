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

use Flame\Rest\Request\Parameters;
use Tester\TestCase;
use Tester\Assert;

require_once __DIR__ . '/../../bootstrap.php';

/**
 * Class ParametersTest
 * @package FlameTests\Rest\Request
 */
class ParametersTest extends TestCase
{
	/** @var Parameters */
	private $parameters;

	protected function setUp()
	{
		$this->parameters = new Parameters([
			'data' => ['item' => 'value'],
			'query' => ['id' => 1, 'stringId' => '1'],
			'action' => 'create',
			'id' => '1'
		]);
	}

	public function testGetData()
	{
		Assert::same('value', $this->parameters->getData('item'));
		Assert::equal(['item' => 'value'], $this->parameters->getData());
		Assert::null($this->parameters->getData('non-exist'));
		Assert::same('default', $this->parameters->getData('non-exist', 'default'));
	}

	public function testGetQuery()
	{
		Assert::same(1, $this->parameters->getQuery('id'));
		Assert::same(1, $this->parameters->getQuery('stringId'));
		Assert::equal(['id' => 1, 'stringId' => '1'], $this->parameters->getQuery());
		Assert::null($this->parameters->getQuery('non-exist'));
		Assert::same('default', $this->parameters->getQuery('non-exist', 'default'));
	}

	public function testGetAction()
	{
		Assert::same('create', $this->parameters->getAction());
	}

	public function testGetId()
	{
		Assert::same(1, $this->parameters->getId());
	}
}

run(new ParametersTest());
