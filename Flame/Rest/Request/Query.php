<?php
/**
 * Class Query
 *
 * @author: Jiří Šifalda <sifalda.jiri@gmail.com>
 * @date: 08.07.13
 */
namespace Flame\Rest\Request;

use Nette\Object;

class Query extends Object
{

	/** @var array  */
	private $queries;

	/**
	 * @param array $query
	 */
	public function __construct(array $query)
	{
		$this->queries = $query;
	}

	/**
	 * @param $name
	 * @param null $default
	 * @return null
	 */
	public function getParam($name, $default = null)
	{
		return (isset($this->queries[$name])) ? $this->queries[$name] : $default;
	}

}