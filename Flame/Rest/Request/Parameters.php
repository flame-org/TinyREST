<?php
/**
 * Class Parameters
 *
 * @author: Jiří Šifalda <sifalda.jiri@gmail.com>
 * @date: 07.07.13
 */
namespace Flame\Rest\Request;

use Nette\Http\UrlScript;
use Nette\Object;
use Nette\Utils\Json;

class Parameters extends Object
{
	/** @var  array */
	private $data;

	/**
	 * @param array $data
	 */
	function __construct(array $data)
	{
		$this->data = $data;
	}

	/**
	 * @return string
	 */
	public function getId()
	{
		return $this->getKey('id');
	}

	/**
	 * @return string
	 */
	public function getAction()
	{
		return $this->getKey('action');
	}

	/**
	 * @return string
	 */
	public function getFormat()
	{
		return $this->getKey('format');
	}

	/**
	 * @return array
	 */
	public function getAssociations()
	{
		return $this->getKey('associations');
	}

	/**
	 * @param bool $invalidate
	 * @return mixed
	 */
	public function getData($invalidate = true)
	{
		$data = $this->getKey('data');
		if($data && $invalidate && $this->getFormat() === 'json') {
			$data = Json::decode($data);
		}

		return $data;
	}

	/**
	 * @return Query
	 */
	public function getQuery()
	{
		$query = $this->getKey('query');
		if(is_array($query)) {
			return new Query($query);
		}

		return new Query(array());
	}

	/**
	 * @param $name
	 * @param null $default
	 * @return mixed
	 */
	protected function getKey($name, $default = null)
	{
		return (isset($this->data[$name])) ? $this->data[$name] : $default;
	}
}