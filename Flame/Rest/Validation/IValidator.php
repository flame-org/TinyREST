<?php
/**
 * Class IValidator
 *
 * @author: Jiří Šifalda <sifalda.jiri@gmail.com>
 * @date: 07.07.13
 */
namespace Flame\Rest\Validation;

/**
 * Class IValidator
 *
 * @package Flame\Rest\Validation
 */
interface IValidator
{

	/**
	 * @param array $data
	 * @return array
	 */
	public function validate(array $data);
}