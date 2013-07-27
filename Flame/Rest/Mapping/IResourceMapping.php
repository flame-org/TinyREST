<?php
/**
 * Class IResourceMapping
 *
 * @author: Jiří Šifalda <sifalda.jiri@gmail.com>
 * @date: 27.07.13
 */
namespace Flame\Rest\Mapping;

interface IResourceMapping
{

	/**
	 * Get resource which will be send like response
	 *
	 * @return array
	 */
	public function getResource();
} 