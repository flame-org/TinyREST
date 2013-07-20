<?php
/**
 * Class ArrayData
 *
 * @author: Jiří Šifalda <sifalda.jiri@gmail.com>
 * @date: 16.07.13
 */
namespace Flame\Rest\Types;

use Nette\InvalidStateException;

class ArrayData extends Data
{

	/**
	 * @param array $data
	 */
	public function __construct($data)
	{
		parent::__construct((array) $data);
	}

	/**
	 * @param $name
	 * @param null $default
	 * @return mixed
	 */
	public function getByKey($name, $default = null)
	{
		return $this->getValue($name, $default);
	}

	/**
	 * @return array|mixed
	 */
	public function getData()
	{
		return $this->data;
	}

	/**
	 * @param string $name
	 * @return mixed
	 * @throws \Nette\InvalidStateException
	 */
	public function get($name)
	{
		if(!isset($this->data[$name])) {
			throw new InvalidStateException('Value with key "' . $name . '" does not exist');
		}

		return $this->data[$name];
	}

	/**
	 * @param string $name
	 * @param null $default
	 * @return mixed
	 */
	public function getValue($name, $default = null)
	{
		return (isset($this->data[$name])) ? $this->data[$name] : $default;
	}
}