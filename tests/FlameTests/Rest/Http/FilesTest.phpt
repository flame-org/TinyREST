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

namespace FlameTests\Rest\Http;

use Flame\Rest\Http\Files;
use Nette\Http\FileUpload;
use Tester\TestCase;
use Tester\Assert;

require_once __DIR__ . '/../../bootstrap.php';

/**
 * Class FilesTest
 * @package FlameTests\Rest\Http
 */
class FilesTest extends TestCase
{
	public function testGetFiles()
	{
		$files = new Files([__FILE__]);
		Assert::equal([new FileUpload(__FILE__)], $files->getFiles());
	}
}

run(new FilesTest());
