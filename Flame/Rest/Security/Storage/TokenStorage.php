<?php
/**
 * Class TokenStorage
 *
 * @author Jiří Šifalda <sifalda.jiri@gmail.com>
 * @date 06.02.14
 */
namespace Flame\Rest\Security\Storage;

use Nette\Object;
use Nette\Http\Session;

class TokenStorage extends Object
{

	const SESSION_KEY = 'hash-storage';

	/** @var \Nette\Http\Session  */
	private $session;

	/**
	 * @param Session $session
	 */
	function __construct(Session $session)
	{
		$this->session = $session;
	}

	/**
	 * @param $hash
	 * @return bool
	 */
	public function isHash($hash)
	{
		$section = $this->getSection();

		if (isset($section[$hash])) {
			return true;
		}

		return false;
	}

	/**
	 * @param string $hash
	 * @return $this
	 */
	public function addHash($hash)
	{
		$section = $this->getSection();
		$section[(string) $hash] = new \DateTime;
		return $this;
	}

	/**
	 * @param string $hash
	 * @return $this
	 */
	public function removeHash($hash)
	{
		$section = $this->getSection();
		if ($this->isHash($hash)) {
			unset($section[$hash]);
		}

		return $this;
	}

	/**
	 * @return \Nette\Http\SessionSection
	 */
	private function getSection()
	{
		return $this->session->getSection(self::SESSION_KEY);
	}
} 