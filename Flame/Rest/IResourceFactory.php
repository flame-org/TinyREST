<?php
/**
 * Class IResourceFactory
 *
 * @author: Jiří Šifalda <sifalda.jiri@gmail.com>
 * @date: 07.07.13
 */
namespace Flame\Rest;

/**
 * IResourceFactory
 * @package Drahak\Restful
 * @author Drahomír Hanák
 */
interface IResourceFactory
{

	/**
	 * Create new API resource
	 * @return IResource
	 */
	public function create();

}