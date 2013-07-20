<?php
/**
 * Class ObjectData
 *
 * @author: Jiří Šifalda <sifalda.jiri@gmail.com>
 * @date: 20.07.13
 */
namespace Flame\Rest\Types;

use Nette\InvalidStateException;

class ObjectData extends Data
{

	/**
	 * @param $data
	 */
	public function __construct($data)
	{
		parent::__construct((object) $data);
	}

	/**
	 * @param string $name
	 * @return mixed
	 * @throws InvalidStateException
	 */
	public function get($name)
	{
		if(!isset($this->data->$name)) {
			throw new InvalidStateException('Value with key "' . $name . '" does not exist');
		}

		return $this->data->$name;
	}

	/**
	 * @param string $name
	 * @param null $default
	 * @return mixed
	 */
	public function getValue($name, $default = null)
	{
		return (isset($this->data->$name)) ? $this->data->$name : $default;
	}

	/**
	 * @return mixed|object
	 */
	public function getData()
	{
		return $this->data;
	}
}