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

namespace FlameTests\Rest\Application\Routers;

use Flame\Rest\Application\Routers\RestRoute;
use Flame\Rest\Application\Routers\SpecificRestRoute;
use Nette\Http\Request;
use Nette\Http\UrlScript;
use Tester\TestCase;
use Tester\Assert;

require_once __DIR__ . '/../../../bootstrap.php';

/**
 * Class RestRouteTest
 * @package FlameTests\Rest\Application\Routers
 */
class RestRouteTest extends TestCase
{
	/**
	 * @param string $expected
	 * @param RestRoute $route
	 * @dataProvider provideTestGetPathData
	 */
	public function testGetPath($expected, $route)
	{
		Assert::same($expected, $route->getPath());
	}

	/**
	 * @return array
	 */
	public function provideTestGetPathData()
	{
		return [
			['api/v1', new RestRoute("Api:V1")],
			['api', new RestRoute("Api")]
		];
	}

	/**
	 * @param array $expected
	 * @param Request $httpRequest
	 * @dataProvider provideTestMatchData
	 */
	public function testMatch($expected, $httpRequest)
	{
		$route = new RestRoute("Api:V1");
		$request = $route->match($httpRequest);
		Assert::same($request->getMethod(), $expected['method']);
		Assert::same($request->getPresenterName(), $expected['presenterName']);
		Assert::same($request->getParameter('action'), $expected['action']);
		if (isset($expected['id'])) {
			Assert::same($request->getParameter('id'), $expected['id']);
		}
	}

	/**
	 * @return array
	 */
	public function provideTestMatchData()
	{
		return [
			[
				[
					'method' => 'POST',
					'presenterName' => 'Api:V1:Users',
					'action' => 'create'
				],
				new Request(new UrlScript("http://fake.local/api/v1/users"), null, null, null, null, ['Content-type' => 'application/json'], "POST")
			],
			[
				[
					'method' => 'GET',
					'presenterName' => 'Api:V1:Users',
					'action' => 'readall'
				],
				new Request(new UrlScript("http://fake.local/api/v1/users"), null, null, null, null, ['Content-type' => 'application/json'], "GET")
			],
			[
				[
					'method' => 'GET',
					'presenterName' => 'Api:V1:Users',
					'action' => 'read',
					'id' => '1'
				],
				new Request(new UrlScript("http://fake.local/api/v1/users/1"), null, null, null, null, ['Content-type' => 'application/json'], "GET")
			],
			[
				[
					'method' => 'PUT',
					'presenterName' => 'Api:V1:Users',
					'action' => 'update',
					'id' => '1'
				],
				new Request(new UrlScript("http://fake.local/api/v1/users/1"), null, null, null, null, ['Content-type' => 'application/json'], "PUT")
			],
			[
				[
					'method' => 'DELETE',
					'presenterName' => 'Api:V1:Users',
					'action' => 'delete',
					'id' => '1'
				],
				new Request(new UrlScript("http://fake.local/api/v1/users/1"), null, null, null, null, ['Content-type' => 'application/json'], "DELETE")
			]
		];
	}
}

run(new RestRouteTest());
