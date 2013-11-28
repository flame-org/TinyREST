<?php
/**
 * Class Parameters
 *
 * @author: Jiří Šifalda <sifalda.jiri@gmail.com>
 * @date: 07.07.13
 */
namespace Flame\Rest\Request;

use Nette\ArrayHash;
use Nette\Http\Request;
use Nette\Object;

/**
 * Class Parameters
 *
 * @package Flame\Rest\Request
 *
 * @property-read int $id
 * @property-read string $action
 * @property-read string $format
 * @property-read mixed $data
 * @property-read mixed $query
 * @property-read mixed $associations
 */
class Parameters extends Object implements IParameters
{
	
	/** @var \Nette\ArrayHash  */
	private $data;

	/** @var \Nette\Http\Request  */
	private $request;

	/**
	 * @param array $data
	 * @param Request $request
	 */
	function __construct(array $data, Request $request)
	{
		$defaults = array(
			'id' => '',
			'action' => '',
			'format' => '',
			'associations' => array(),
			'data' => array(),
		);
		$this->data = ArrayHash::from(array_merge($defaults, $data));
		$this->request = $request;
	}

	/**
	 * @return int
	 */
	public function getId()
	{
		return (int) $this->data->id;
	}

	/**
	 * @return string
	 */
	public function getAction()
	{
		return (string) $this->data->action;
	}

	/**
	 * @return string
	 */
	public function getFormat()
	{
		return (string) $this->data->format;
	}

	/**
	 * @param null|string $name
	 * @param null $default
	 * @return mixed
	 */
	public function getAssociations($name = null, $default = null)
	{
		if($name !== null) {
			if(isset($this->data->associations[$name])) {
				return $this->data->associations[$name];
			}

			return $default;
		}

		return $this->data->associations;
	}

	/**
	 * @return mixed
	 */
	public function getData()
	{
		return $this->data->data;
	}

	/**
	 * @param null $query
	 * @param null $default
	 * @return mixed
	 */
	public function getQuery($query = null, $default = null)
	{
		if($query !== null) {
			return $this->request->getQuery($query, $default);
		}

		return $this->request->getQuery();
	}
}