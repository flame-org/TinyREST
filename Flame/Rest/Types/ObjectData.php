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
	 * @return mixed|ObjectData
	 * @throws InvalidStateException
	 */
	public function get($name)
	{
		if(!isset($this->data->$name)) {
			throw new InvalidStateException('Value with key "' . $name . '" does not exist');
		}

		return $this->getPiece($name);
	}

	/**
	 * @param string $name
	 * @param null $default
	 * @return mixed|ObjectData
	 */
	public function getValue($name, $default = null)
	{
		return (isset($this->data->$name)) ? $this->getPiece($name) : $default;
	}

	/**
	 * @param $name
	 * @return ObjectData
	 */
	protected function getPiece($name)
	{
		$data = $this->data->$name;
		if(is_array($data) || is_object($data)) {
			$data = new ObjectData($data);
		}

		return $data;
	}

	/**
	 * @return mixed|object
	 */
	public function getData()
	{
		return $this->data;
	}
}