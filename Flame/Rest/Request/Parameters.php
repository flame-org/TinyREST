<?php
/**
 * Class Parameters
 *
 * @author: Jiří Šifalda <sifalda.jiri@gmail.com>
 * @date: 07.07.13
 */
namespace Flame\Rest\Request;

use Nette\ArrayHash;
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
				return $this->validateValue($this->data->associations[$name]);
			}

			return $default;
		}

		return $this->data->associations;
	}

	/**
	 * @param null|string $name
	 * @param null $default
	 * @return mixed
	 */
	public function getData($name = null, $default = null)
	{
		if ($name !== null) {
			if (isset($this->data->data[$name])) {
				return $this->validateValue($this->data->data[$name]);
			}

			return $default;
		}

		return $this->data->data;
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
				return $this->validateValue($this->data->query[$query]);
			}

			return $default;
		}

		return $this->data->query;
	}

	/**
	 * @param $value
	 * @return mixed
	 */
	protected function validateValue($value)
	{
		if (is_array($value)) {
			$value = array_map(function ($item) {
				return $this->validateValue($item);
			}, $value);
		} elseif ($value === 'null') {
			$value = null;
		} elseif (is_numeric($value)) {
			$value = (int) $value;
		} elseif ($value === 'true' || $value === 'false') {
			$value = (bool) $value;
		}

		return $value;
	}
}