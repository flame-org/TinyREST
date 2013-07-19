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
	 * @param array $data
	 * @return array
	 */
	public function parseObject(array $data)
	{
		if(count($data)) {
			foreach ($data as &$value) {
				if(!is_object($value)) {
					continue;
				}

				if(method_exists($value, 'toArray')) {
					$value = $value->toArray();
				}else{
					$value = (array) $value;
				}
			}
		}

		return $data;
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