<?php
/**
 * Class Parameters
 *
 * @author: Jiří Šifalda <sifalda.jiri@gmail.com>
 * @date: 07.07.13
 */
namespace Flame\Rest\Request;

use Flame\Rest\Types\ArrayData;
use Nette\Object;
use Nette\Utils\Json;

class Parameters extends Object
{
	
	/** @var \Flame\Rest\Types\ArrayData  */
	private $data;

	/**
	 * @param array $data
	 */
	function __construct(array $data)
	{
		$this->data = new ArrayData($data);
	}

	/**
	 * @return mixed
	 */
	public function getId()
	{
		return $this->data->getByKey('id');
	}

	/**
	 * @return string
	 */
	public function getAction()
	{
		return $this->data->getByKey('action');
	}

	/**
	 * @return string
	 */
	public function getFormat()
	{
		return $this->data->getByKey('format');
	}

	/**
	 * @return Association
	 */
	public function getAssociations()
	{
		return new Association($this->data->getByKey('associations', array()));
	}

	/**
	 * @param bool $invalidate
	 * @return mixed
	 */
	public function getData($invalidate = true)
	{
		$data = $this->data->getByKey('data');
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
		return new Query($this->data->getByKey('query', array()));
	}
}