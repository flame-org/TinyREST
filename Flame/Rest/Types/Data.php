<?php
/**
 * Class Data
 *
 * @author: Jiří Šifalda <sifalda.jiri@gmail.com>
 * @date: 20.07.13
 */
namespace Flame\Rest\Types;

abstract class Data implements IData
{

	/** @var  mixed */
	protected $data;

	/**
	 * @param $data
	 */
	public function __construct($data)
	{
		$this->data = $data;
	}

}