<?php
/**
 * Class Value
 *
 * @author: Jiří Šifalda <sifalda.jiri@gmail.com>
 * @date: 16.07.13
 */
namespace Flame\Rest\Types;

use Nette\Utils\Json;

class Value implements ITypes
{

	/** @var mixed */
	private $value;

	/** @var string */
	private $originalType;

	/**
	 * @param $value
	 */
	public function __construct($value)
	{
		$this->value = $value;
		$this->originalType = gettype($value);
	}

	/**
	 * @return string
	 */
	public function parseString()
	{
		return (string) $this->getOriginal();
	}

	/**
	 * @return int
	 */
	public function parseInt()
	{
		return (int) $this->getOriginal();
	}

	/**
	 * @return array
	 */
	public function parseArray()
	{
		return (array) $this->getOriginal();
	}

	/**
	 * @return mixed
	 */
	public function parseJSON()
	{
		return Json::decode($this->parseString());
	}

	/**
	 * @return mixed
	 */
	public function getOriginal()
	{
		return $this->value;
	}

	/**
	 * @return string
	 */
	public function getOriginalType()
	{
		return $this->originalType;
	}

	/**
	 * @return string
	 */
	public function __toString()
	{
		return $this->parseString();
	}

}