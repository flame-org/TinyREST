<?php
/**
 * Class ResourceFactory
 *
 * @author: Jiří Šifalda <sifalda.jiri@gmail.com>
 * @date: 07.07.13
 */
namespace Flame\Rest;

use Flame\Rest\Validation\ValidatorComposite;
use Nette\Object;

/**
 * Class ResourceFactory
 *
 * @package Flame\Rest
 */
class ResourceFactory extends Object implements IResourceFactory
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
	 * Create new API resource
	 * @return IResource
	 */
	public function create()
	{
		return new ExtendedResource($this->validatorComposite);
	}


}