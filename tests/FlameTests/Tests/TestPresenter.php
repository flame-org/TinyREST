<?php
/**
 * This file is part of the TinyREST package.
 *
 * (c) Ondřej Záruba <zarubaondra@gmail.com>
 *
 * For the full copyright and license information, please view the license.md
 * file that was distributed with this source code.
 */

namespace FlameTests\Tests;

use Flame\Rest\Application\UI\RestPresenter;

/**
 * Class MockPresenter
 * @package FlameTests\Rest\Tests
 */
class TestPresenter extends RestPresenter
{
	public function actionReadAll()
	{
		$this->resource->data = ['original' => true];
	}
}
