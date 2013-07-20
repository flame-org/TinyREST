<?php
/**
 * Class Code
 *
 * @author: Jiří Šifalda <sifalda.jiri@gmail.com>
 * @date: 20.07.13
 */
namespace Flame\Rest\Response;

use Nette\Object;

class Code extends Object implements ICode
{

	/**
	 * Return list of defined status codes
	 *
	 * @return array
	 */
	public function getCodes()
	{
		return $this->getReflection()->getConstants();
	}
}