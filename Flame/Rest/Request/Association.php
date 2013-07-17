<?php
/**
 * Class Association
 *
 * @author: Jiří Šifalda <sifalda.jiri@gmail.com>
 * @date: 16.07.13
 */
namespace Flame\Rest\Request;

use Flame\Rest\Types\ArrayData;
use Nette\Object;

class Association extends Object
{

	/** @var \Flame\Rest\Types\ArrayData  */
	private $associations;

	/**
	 * @param $association
	 */
	public function __construct($association)
	{
		$this->associations = new ArrayData($association);
	}

	/**
	 * @param $name
	 * @param null $default
	 * @return null
	 */
	public function get($name, $default = null)
	{
		return $this->associations->getByKey($name, $default);
	}
}