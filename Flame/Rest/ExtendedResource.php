<?php
/**
 * Class ExtendedResource
 *
 * @author: Jiří Šifalda <sifalda.jiri@gmail.com>
 * @date: 27.07.13
 */
namespace Flame\Rest;

use Flame\Rest\Mapping\IResourceMapping;
use Flame\Rest\Validation\ResourceValidator;

class ExtendedResource extends Resource
{

	/** @var  ResourceValidator */
	private $validator;

	/**
	 * @param ResourceValidator $validator
	 */
	function __construct(ResourceValidator $validator)
	{
		$this->validator = $validator;
	}

	/**
	 * @param $data
	 * @return $this
	 */
	public function setData($data)
	{
		$this->data = $data;
		return $this;
	}

	/**
	 * @return array
	 */
	public function getData()
	{
		return $this->validator->getValidData(parent::getData());
	}

} 