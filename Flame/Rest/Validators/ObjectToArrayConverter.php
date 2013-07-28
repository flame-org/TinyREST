<?php
/**
 * Class ObjectToArrayConverter
 *
 * @author: Jiří Šifalda <sifalda.jiri@gmail.com>
 * @date: 19.07.13
 */
namespace Flame\Rest\Validators;

use Flame\Rest\Validation\IValidator;
use Nette\Object;

class ObjectToArrayConverter extends Object implements IValidator
{

	/**
	 * @param $array
	 * @return array
	 */
	public function parseObject($array)
	{
		if ($array instanceof \Traversable) {
			$array = iterator_to_array($array);
		}

		if (!is_array($array)) {
			if(is_object($array)) {
				if(method_exists($array, 'toFullArray')) {
					return $array->toFullArray();
				}

				return (array) $array;
			}

			return $array;
		}

		foreach ($array as $key => $value) {
			if ($value instanceof \Traversable || is_array($array) || is_object($array)) {
				$array[$key] = $this->parseObject($value);
			}
		}

		return $array;
	}

	/**
	 * @param array $data
	 * @return array
	 */
	public function validate(array $data)
	{
		return $this->parseObject($data);
	}
}