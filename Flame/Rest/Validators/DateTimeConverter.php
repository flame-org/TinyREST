<?php
/**
 * Class DateTimeConverter
 *
 * @author: Jiří Šifalda <sifalda.jiri@gmail.com>
 * @date: 07.07.13
 */
namespace Flame\Rest\Validators;

use Flame\Rest\Validation\IValidator;
use Traversable;
use DateTime;
use Nette\Object;

/**
 * Class DateTimeConverter
 *
 * @package Flame\Rest\Validation
 */
class DateTimeConverter extends Object implements IValidator
{

	/** @var  string */
	private $format;

	/**
	 * @param string $format
	 */
	public function __construct($format)
	{
		$this->format = (string) $format;
	}

	/**
	 * @param $array
	 * @return array
	 */
	public function parseDateTime($array)
	{
		if ($array instanceof Traversable) {
			$array = iterator_to_array($array);
		}

		if (!is_array($array)) {
			return $array instanceof DateTime ? $array->format($this->format) : $array;
		}

		foreach ($array as $key => $value) {
			if ($value instanceof Traversable || is_array($array)) {
				$array[$key] = $this->parseDateTime($value);
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
		return $this->parseDateTime($data);
	}
}