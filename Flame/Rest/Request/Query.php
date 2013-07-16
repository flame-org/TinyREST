<?php
/**
 * Class Query
 *
 * @author: Jiří Šifalda <sifalda.jiri@gmail.com>
 * @date: 08.07.13
 */
namespace Flame\Rest\Request;

use Flame\Rest\Types\ArrayData;
use Nette\Object;

class Query extends Object
{

	/** @var \Flame\Rest\Types\ArrayData  */
	private $queries;

	/**
	 * @param $query
	 */
	public function __construct($query)
	{
		$this->queries = new ArrayData($query);
	}

	/**
	 * @param $name
	 * @param null $default
	 * @return null
	 */
	public function getParam($name, $default = null)
	{
		return $this->queries->getValueByKey($name, $default);
	}

}