<?php
/**
 * Class ResourceMapping
 *
 * @author: Jiří Šifalda <sifalda.jiri@gmail.com>
 * @date: 27.07.13
 */
namespace Flame\Rest\Mapping;

use Nette\InvalidArgumentException;
use Nette\Object;

abstract class ResourceMapping extends Object implements IResourceMapping
{

	/** @var array|object */
	protected $data;

	/**
	 * @param array|object $data
	 * @throws InvalidArgumentException
	 */
	public function __construct($data)
	{
		if(!is_array($data) && !is_object($data)) {
			throw new InvalidArgumentException('Invalid data given. Must be array or object');
		}

		if($data instanceof \Traversable) {
			$data = iterator_to_array($data);
		}

		$this->data = $data;
	}

	/**
	 * @return array
	 */
	public function getResource()
	{
		$resource = array();
		if(count($keys = $this->getMapping())) {
			$isArray = is_array($this->data);
			foreach ($keys as $key) {
				if ($isArray) {
					$resource[$key] = $this->data[$key];
				}else{
					$resource[$key] = $this->data->$key;
				}
			}
		}

		return $resource;
	}

	/**
	 * Get list of keys which will be send in response
	 *
	 * @return array
	 */
	abstract protected function getMapping();
} 