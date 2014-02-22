<?php
/**
 * Class ICors
 *
 * @author Jiří Šifalda <sifalda.jiri@gmail.com>
 * @date 22.02.14
 */
namespace Flame\Rest\Security;

use Flame\Rest\Request\IParameters;

interface ICors
{

	const HEADER_ORIGIN = 'Access-Control-Allow-Origin';
	const HEADER_HEADERS = 'Access-Control-Allow-Headers';
	const HEADER_METHODS = 'Access-Control-Allow-Methods';

	/**
	 * @param IParameters $input
	 * @return $this
	 */
	public function configure(IParameters $input);
} 