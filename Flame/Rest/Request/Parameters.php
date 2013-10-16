<?php
/**
 * Class Parameters
 *
 * @author: Jiří Šifalda <sifalda.jiri@gmail.com>
 * @date: 07.07.13
 */
namespace Flame\Rest\Request;

use Nette\ArrayHash;
use Nette\Utils\Json;
use Nette\Object;

class Parameters extends Object
{
	
	/** @var \Nette\ArrayHash  */
	private $data;

	/**
	 * @param array $data
	 */
	function __construct(array $data)
	{
		$defaults = array(
			'id' => '',
			'action' => '',
			'format' => '',
			'associations' => array(),
			'data' => array(),
			'query' => array(),
		);
		$this->data = ArrayHash::from(array_merge($defaults, $data));
	}

	/**
	 * @return string
	 */
	public function getId()
	{
		return (string) $this->data->id;
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
	 * @param bool $invalidate
	 * @return mixed
	 */
	public function getData($invalidate = true)
	{
		$data = $this->data->data;
		if($data && $invalidate === true && $this->getFormat() === 'json') {
			$data = ArrayHash::from(Json::decode((string) $data, 1));
		}

		return $data;
	}

	/**
	 * @param null|string $query
	 * @param null $default
	 * @return mixed
	 */
	public function getQuery($query = null, $default = null)
	{
		if($query !== null) {
			if(isset($this->data->query[$query])) {
				return $this->data->query[$query];
			}

			return $default;
		}

		return $this->data->query;
	}
}