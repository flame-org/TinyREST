<?php
/**
 * Class ResourceFactory
 *
 * @author: Jiří Šifalda <sifalda.jiri@gmail.com>
 * @date: 07.07.13
 */
namespace Flame\Rest;

use Nette\Object;

/**
 * Class ResourceFactory
 *
 * @package Flame\Rest
 */
class ResourceFactory extends Object implements IResourceFactory
{

	/**
	 * Create new API resource
	 * @return IResource
	 */
	public function create()
	{
		return new Resource();
	}
}