<?php
/**
 * Class RefererAuthenticator
 *
 * @author Jiří Šifalda <sifalda.jiri@gmail.com>
 * @date 21.02.14
 */
namespace Flame\Rest\Security\Authenticators;

use Flame\Rest\Security\ForbiddenRequestException;
use Flame\Rest\Security\IAuthenticator;
use Nette\Diagnostics\Debugger;
use Nette\Object;

class RefererAuthenticator extends Object implements IAuthenticator
{

	/** @var  array */
	private $allowedReferers = array();

	/**
	 * @param array $allowedReferers
	 */
	function __construct(array $allowedReferers)
	{
		foreach ($allowedReferers as $referer) {
			$this->allowedReferers[] = $this->trimHost($referer);
		}
	}

	/**
	 * @param $element
	 * @throws \Flame\Rest\Security\ForbiddenRequestException
	 */
	public function authenticate($element)
	{
		$referer = $this->getReferer();
		if (!in_array($referer, $this->allowedReferers)) {
			Debugger::log('Invalid HTTP REFERER header "' . $referer . '"', Debugger::DETECT);
			throw new ForbiddenRequestException;
		}
	}

	/**
	 * @return mixed
	 */
	protected function getReferer()
	{
		if (isset($_SERVER['HTTP_REFERER'])) {
			return $this->trimHost($_SERVER['HTTP_REFERER']);
		}
	}

	/**
	 * @param $hostname
	 * @return string
	 */
	private function trimHost($hostname)
	{
		return trim($hostname, '/');
	}
}