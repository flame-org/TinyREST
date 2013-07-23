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
	public function parseDateTime(array &$array)
	{
		array_walk_recursive($array, function (&$item) {
			if ($item instanceof DateTime) {
				$item = $item->format($this->format);
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
		return $this->parseDateTime($data);
	}
}