<?php
/**
 * Class ArrayData
 *
 * @author: Jiří Šifalda <sifalda.jiri@gmail.com>
 * @date: 16.07.13
 */
namespace Flame\Rest\Types;

use Nette\Object;

class ArrayData extends Object
{

	/** @var array  */
	private $data;

	/**
	 * @param array $data
	 */
	public function __construct($data)
	{
		$this->data = (array) $data;
	}

	/**
	 * @param $name
	 * @param null $default
	 * @return mixed
	 */
	public function getByKey($name, $default = null)
	{
		return (isset($this->data[$name])) ? $this->data[$name] : $default;
	}

	/**
	 * @return array
	 */
	public function getData()
	{
		return $this->data;
	}

}