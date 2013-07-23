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
	public function parseObject(array &$array)
	{
		array_walk_recursive($array, function (&$item) {
			if(is_object($item)) {
				if(method_exists($item, 'toArray')) {
					$item = $item->toArray(true);
				}elseif ($item instanceof \Traversable) {
					$item = iterator_to_array($item);
				}else{
					$item = (array) $item;
				}
			}

			return $item;
		});

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