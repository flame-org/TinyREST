<?php
/**
 * Class RestExtension
 *
 * @author: Jiří Šifalda <sifalda.jiri@gmail.com>
 * @date: 07.07.13
 */
namespace Flame\Rest\DI;

use Nette\DI\CompilerExtension;
use Nette\DI\ContainerBuilder;
use Nette\Configurator;
use Nette\PhpGenerator\ClassType;
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
		'systemSalt' => 'deepSalt34',
		'authenticators' => array(),
		'tokens' => array(
			'expiration' => '+ 30 days'
		),
		'cors' => array(
			'origin' => '*',
			'headers' => '*',
			'methods' => '*'
		),
		'ips' => array(),
		'referers' => array()
	);

	/**
	 * @return void
	 */
	public function loadConfiguration()
	{
		$container = $this->getContainerBuilder();
		$config = $this->getConfig($this->defaults);

		$this->configValidation($config);
		$this->processAuthenticators($container, $config);

		$container->addDefinition($this->prefix('resourceFactory'))
			->setClass('Flame\Rest\ResourceFactory');

		$container->addDefinition($this->prefix('parametersFactory'))
			->setClass('Flame\Rest\Request\ParametersFactory');

		$container->addDefinition($this->prefix('authorizationHash'))
			->setClass('Flame\Rest\Security\Storage\AuthorizationHash');

		$container->addDefinition($this->prefix('user'))
			->setClass('Flame\Rest\Security\User');

		$container->addDefinition($this->prefix('basicTokenFactory'))
			->setClass('Flame\Rest\Security\Tokens\BasicTokenFactory')
			->setArguments(array($config['systemSalt']));
	}

	/**
	 * @param $config
	 * @return void
	 */
	public function configValidation($config)
	{
		Validators::assertField($config, 'authenticators', 'array');
		Validators::assertField($config, 'ips', 'array');
		Validators::assertField($config, 'referers', 'array');
		Validators::assertField($config, 'tokens', 'array');
		Validators::assertField($config, 'systemSalt', 'string');
		Validators::assertField($config['tokens'], 'expiration', 'string');
	}

	/**
	 * Register REST API extension
	 * @param Configurator $configurator
	 */
	public static function register(Configurator $configurator)
	{
		$configurator->onCompile[] = function($configurator, $compiler) {
			$compiler->addExtension('rest', new RestExtension());
		};
	}

	/**
	 * @param ClassType $class
	 */
	public function afterCompile(ClassType $class)
	{
		$config = $this->getConfig($this->defaults);
		if(isset($config['cors']) && $config['cors']) {
			$container = $this->getContainerBuilder();
			$initialize = $class->methods['initialize'];

			$initialize->addBody($container->formatPhp("header('Access-Control-Allow-Origin: " . ((isset($config['cors']['origin']) ? $config['cors']['origin'] : '*')) . "');", array()));
			$initialize->addBody($container->formatPhp("header('Access-Control-Allow-Headers: " . ((isset($config['cors']['headers']) ? $config['cors']['headers'] : '*')) . "');", array()));
			$initialize->addBody($container->formatPhp("header('Access-Control-Allow-Methods: " . ((isset($config['cors']['methods']) ? $config['cors']['methods'] : '*')) . "');", array()));
		}
	}

	/**
	 * @param ContainerBuilder $container
	 * @param array $config
	 */
	private function processAuthenticators(ContainerBuilder $container, array $config)
	{
		$authentication = $container->addDefinition($this->prefix('authentication'))
			->setClass('Flame\Rest\Security\Authentication');

		if (count($config['ips'])) {
			$ipAuthenticator = $container->addDefinition($this->prefix('ipAuthenticator'))
				->setClass('Flame\Rest\Security\Authenticators\IpAuthenticator')
				->setArguments(array($config['ips']));
			$authentication->addSetup('addAuthenticator', array($ipAuthenticator));
		}

		if (count($config['referers'])) {
			$refererAuthenticator = $container->addDefinition($this->prefix('refererAuthenticator'))
				->setClass('Flame\Rest\Security\Authenticators\RefererAuthenticator')
				->setArguments(array($config['referers']));
			$authentication->addSetup('addAuthenticator', array($refererAuthenticator));
		}

		foreach($config['authenticators'] as $k => $authenticatorConfig) {
			$authenticator = $container->addDefinition($this->prefix('authenticator' . $k))
				->setClass($authenticatorConfig);
			$authentication->addSetup('addAuthenticator', array($authenticator));
		}
	}

}