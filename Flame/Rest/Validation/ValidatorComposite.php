<?php
/**
 * Class ValidatorComposite
 *
 * @author: Jiří Šifalda <sifalda.jiri@gmail.com>
 * @date: 04.10.13
 */
namespace Flame\Rest\Validation;

use Nette\Object;

class ValidatorComposite extends Object implements IValidator
{

	/** @var IValidator[]  */
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
	public function validate(array $data)
	{
		foreach ($this->validators as $validator) {
			$data = $validator->validate($data);
		}

		return $data;
	}
}