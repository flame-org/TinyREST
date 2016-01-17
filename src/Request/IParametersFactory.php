<?php
/**
 * Class IParametersFactory
 *
 * @author: Jiří Šifalda <sifalda.jiri@gmail.com>
 * @date: 26.10.13
 */
namespace Flame\Rest\Request;

interface IParametersFactory
{


	/**
	 * @param array $data
	 * @return IParameters
	 */
	public function create(array $data = array());
} 