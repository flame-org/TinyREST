<?php
/**
 * Class ResourceFactory
 *
 * @author: Jiří Šifalda <sifalda.jiri@gmail.com>
 * @date: 07.07.13
 */
namespace Flame\Rest;

use Flame\Rest\Validation\ResourceValidator;
use Nette\Object;

/**
 * Class ResourceFactory
 *
 * @package Flame\Rest
 */
class ResourceFactory extends Object implements IResourceFactory
{

	/** @var ResourceValidator  */
	private $validator;

	/**
	 * @param ResourceValidator $validator
	 */
	public function __construct(ResourceValidator $validator)
	{
		$this->validator = $validator;
	}

	/**
	 * Create new API resource
	 * @return IResource
	 */
	public function create()
	{
		return new ValidResource($this->validator);
	}


}