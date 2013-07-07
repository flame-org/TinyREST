<?php
/**
 * Class ValidResource
 *
 * @author: Jiří Šifalda <sifalda.jiri@gmail.com>
 * @date: 07.07.13
 */
namespace Flame\Rest;

use Flame\Rest\Validation\ResourceValidator;

/**
 * Class ValidResource
 *
 * @package Flame\Rest
 */
class ValidResource extends Resource
{

	/** @var ResourceValidator  */
	private $validator;

	/**
	 * @param ResourceValidator $validator
	 * @param array $data
	 */
	public function __construct(ResourceValidator $validator, array $data = array())
	{
		parent::__construct($data);

		$this->validator = $validator;
	}

	/**
	 * @return array
	 */
	public function getData()
	{
		return $this->validator->getValidData(parent::getData());
	}

}