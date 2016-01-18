<?php
/**
 * This file is part of the TinyRest package.
 *
 * (c) Ondřej Záruba <zarubaondra@gmail.com>
 *
 * For the full copyright and license information, please view the license.md
 * file that was distributed with this source code.
 */

if ((!$loader = @include __DIR__ . '/../../vendor/autoload.php') && (!$loader = @include __DIR__ . '/../../../../autoload.php')) {
	echo 'Install Nette Tester using `composer update --dev`';
	exit(1);
}
/** @var Composer\Autoload\ClassLoader $loader */
$loader->addPsr4("Flame\\Rest\\", __DIR__ . '/../../src');
$loader->addPsr4("FlameTests\\", __DIR__);

// configure environment
Tester\Environment::setup();

define('TEMP_DIR', __DIR__ . '/../temp/' . (isset($_SERVER['argv']) ? md5(serialize($_SERVER['argv'])) : getmypid()));
Tester\Helpers::purge(TEMP_DIR);

function run(Tester\TestCase $testCase) {
	$testCase->run(isset($_SERVER['argv'][1]) ? $_SERVER['argv'][1] : NULL);
}
