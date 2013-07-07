<?php
/**
 * Class ResourceValidator
 *
 * @author: Jiří Šifalda <sifalda.jiri@gmail.com>
 * @date: 07.07.13
 */
namespace Flame\Rest\Validation;

use Nette\Object;

/**
 * Class ResourceValidator
 *
 * @package Flame\Rest\Validation
 */
class ResourceValidator extends Object
{

	/** @var array  */
	private $validators = array();

	/**
	 * @param IValidator $validator
	 */
	public function addValidator(IValidator $validator)
	{
		$this->validators[] = $validator;
	}

	/**
	 * @param array $data
	 * @return array
	 */
	public function getValidData(array $data)
	{
		if(count($this->validators)) {
			foreach ($this->validators as $validator) {
				/** @var IValidator $validator */
				$data = $validator->validate($data);
			}
		}

		return $data;
	}

}