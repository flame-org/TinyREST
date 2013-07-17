<?php
/**
 * Class Parser
 *
 * @author: Jiří Šifalda <sifalda.jiri@gmail.com>
 * @date: 17.07.13
 */
namespace Flame\Rest\Tools;

use Nette\Object;
use Nette\Utils\Json;

class Parser extends Object
{

	/**
	 * @param $value
	 * @return int
	 */
	public function toInt($value)
	{
		return (int) $value;
	}

	/**
	 * @param $value
	 * @return string
	 */
	public function toString($value)
	{
		return (string) $value;
	}

	/**
	 * @param $value
	 * @return array
	 */
	public function toArray($value)
	{
		return (array) $value;
	}

	/**
	 * @param $value
	 * @return mixed
	 */
	public function parseJson($value)
	{
		return Json::decode($this->toString($value));
	}

}