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

	const REST_EXTENSION = 'rest';

	/** @var array  */
	public $defaults = array(
		'errorPresenter' => 'ErrorRest',
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

		$container->addDefinition($this->prefix('authentication'))
			->setClass('Flame\Rest\Security\Authentication');

		$container->addDefinition($this->prefix('basicAuthenticator'))
			->setClass('Flame\Rest\Security\Authenticators\BasicAuthenticator');

		$resourceValidator = $container->addDefinition($this->prefix('resourceValidator'))
			->setClass('Flame\Rest\Validation\ValidatorComposite');

		if(count($validators = $config['validators'])) {
			foreach($validators as $k => $validatorClass) {
				$validator = $container->addDefinition($this->prefix($k))
					->setClass($validatorClass);

				$resourceValidator->addSetup('addValidator', $validator);
			}
		}

		$container->addDefinition($this->prefix('resourceFactory'))
			->setClass('Flame\Rest\ResourceFactory');

		$container->addDefinition($this->prefix('code'))
			->setClass('\Flame\Rest\Response\Code');

		$container->getDefinition('application')
			->setClass('Flame\Rest\Application\Application')
			->addSetup('setRestErrorPresenter', array($config['errorPresenter']));
	}

	/**
	 * @param $config
	 * @return void
	 */
	public function configValidation($config)
	{
		Validators::assertField($config, 'validators', 'array');
		Validators::assertField($config, 'errorPresenter', 'string');
	}

	/**
	 * Register REST API extension
	 * @param Configurator $configurator
	 */
	public static function register(Configurator $configurator)
	{
		$configurator->onCompile[] = function($configurator, $compiler) {
			$compiler->addExtension(self::REST_EXTENSION, new RestExtension());
		};
	}

}