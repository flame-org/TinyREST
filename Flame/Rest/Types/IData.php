<?php
/**
 * Class IData
 *
 * @author: Jiří Šifalda <sifalda.jiri@gmail.com>
 * @date: 20.07.13
 */
namespace Flame\Rest\Types;

interface IData
{

	/**
	 * @param string $name
	 * @return mixed
	 */
	public function get($name);

	/**
	 * @param string $name
	 * @param null $default
	 * @return mixed
	 */
	public function getValue($name, $default = null);

	/**
	 * @return mixed
	 */
	public function getData();

}