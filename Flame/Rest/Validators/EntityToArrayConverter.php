<?php
/**
 * Class EntityToArrayConverter
 *
 * @author: Jiří Šifalda <sifalda.jiri@gmail.com>
 * @date: 04.10.13
 */
namespace Flame\Rest\Validators;

use Flame\Doctrine\Entity;
use Flame\Rest\Validation\IValidator;
use Nette\Object;

class EntityToArrayConverter extends Object implements IValidator
{

	/**
	 * @param $array
	 * @return array
	 */
	public function entityToArray($array)
	{
		if (!is_array($array)) {
			if(is_object($array)) {
				if($array instanceof Entity) {
					return $this->toArray($array);
				}

				return (array) $array;
			}

			return $array;
		}

		foreach ($array as $key => $value) {
			if (is_array($array) || is_object($array)) {
				$array[$key] = $this->entityToArray($value);
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
		return $this->entityToArray($data);
	}

	/**
	 * @param Entity $entity
	 * @return array
	 */
	protected function toArray(Entity $entity)
	{
		$vars = $entity->toArray();
		foreach($vars as &$var) {
			if($var instanceof Entity) {
				$var = $this->toArray($var);
			}elseif($var instanceof \Traversable) {
				$_var = array();
				foreach ($var as $item) {
					if($item instanceof Entity) {
						$item = $item->toArray();
					}

					$_var[] = $item;
				}

				$var = $_var;
			}
		}

		return $vars;
	}
}