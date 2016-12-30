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

namespace FlameTests\Rest\Application\UI;

use FlameTests\Tests\TestPresenter;
use Nette\Application\IPresenterFactory;
use Nette\Application\Request;
use Nette\Application\Responses\JsonResponse;
use Tester\Assert;
use Tester\TestCase;

require_once __DIR__ . '/../../../bootstrap.php';

/**
 * Class RestPresenterTest
 * @package FlameTests\Rest\Application\UI
 */
class RestPresenterTest extends TestCase
{
	/** @var TestPresenter */
	private $presenter;

	protected function setUp()
	{
		$container = getContainer();
		/** @var IPresenterFactory $presenterFactory */
		$presenterFactory = $container->getByType('\Nette\Application\IPresenterFactory');
		$this->presenter = $presenterFactory->createPresenter('Test');
	}

	public function testOnBeforeResponse()
	{
		$this->presenter->onBeforeResponse[] = function ($resource) {
			$resource->token = 'test';
		};
		/** @var JsonResponse $response */
		$response = $this->presenter->run(new Request('Test', 'GET', ['action' => 'readAll']));
		Assert::true($response instanceof JsonResponse);
		Assert::equal(['original' => true, 'token' => 'test'], $response->getPayload());
	}
}

run(new RestPresenterTest());
