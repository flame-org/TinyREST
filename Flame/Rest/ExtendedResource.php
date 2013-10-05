<?php
/**
 * Class ExtendedResource
 *
 * @author: Jiří Šifalda <sifalda.jiri@gmail.com>
 * @date: 27.07.13
 */
namespace Flame\Rest;

use Flame\Rest\Validation\ValidatorComposite;

class ExtendedResource extends Resource
{

	/** @var  ValidatorComposite */
	private $validatorComposite;

	/**
	 * @param ValidatorComposite $validatorComposite
	 */
	function __construct(ValidatorComposite $validatorComposite)
	{
		$this->validatorComposite = $validatorComposite;
	}

	/**
	 * @param $data
	 * @return $this
	 */
	public function setData($data)
	{
		$this->data = $data;
		return $this;
	}

	/**
	 * @return array
	 */
	public function getData()
	{
		return $this->validatorComposite->validate((array) parent::getData());
	}

} 