<?php
/**
 * Class RestExtension
 *
 * @author: Jiří Šifalda <sifalda.jiri@gmail.com>
 * @date: 07.07.13
 */
namespace Flame\Rest\DI;

use Nette\DI\CompilerExtension;
use Nette\Configurator;
use Nette\Utils\Validators;

/**
 * Class RestExtension
 *
 * @package Flame\Rest\DI
 */
class RestExtension extends CompilerExtension
{

	/** @var array  */
	public $defaults = array(
		'time' => array(
			'validator' => 'Flame\Rest\Validators\DateTimeConverter',
			'format' => 'c'
		),
		'validators' => array()
	);

	/**
	 * @return void
	 */
	public function loadConfiguration()
	{
		$container = $this->getContainerBuilder();
		$config = $this->getConfig($this->defaults);

		$this->configValidation($config);

		$resourceValidator = $container->addDefinition($this->prefix('resourceValidator'))
			->setClass('Flame\Rest\Validation\ResourceValidator');

		if(count($config['validators'])) {
			foreach($config['validators'] as $validator) {
				$resourceValidator->addSetup('addValidator', $validator);
			}
		}

		if(substr($config['time']['validator'], 0, 1) !== '@') {
			$dateTimeValidator = $container->addDefinition($this->prefix('dateTimeValidator'))
				->setClass($config['time']['validator'])
				->setArguments(array($config['time']['format']));
		}else{
			$dateTimeValidator = $config['time']['validator'];
		}

		$resourceValidator->addSetup('addValidator', $dateTimeValidator);

		$container->addDefinition($this->prefix('resourceFactory'))
			->setClass('Flame\Rest\ResourceFactory');
	}

	/**
	 * @param $config
	 * @return void
	 */
	public function configValidation($config)
	{
		Validators::assertField($config, 'validators', 'array');
		Validators::assertField($config, 'time', 'array');
		Validators::assertField($config['time'], 'format', 'string');
		Validators::assertField($config['time'], 'validator', 'string');
	}

	/**
	 * Register REST API extension
	 * @param Configurator $configurator
	 */
	public static function install(Configurator $configurator)
	{
		$configurator->onCompile[] = function($configurator, $compiler) {
			$compiler->addExtension('REST', new RestExtension());
		};
	}

}