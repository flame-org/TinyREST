<?php
/**
 * Class IToken
 *
 * @author Jiří Šifalda <sifalda.jiri@gmail.com>
 * @date 21.02.14
 */
namespace Flame\Rest\Security;

interface IToken 
{

	const SEPARATOR = '##';

	/**
	 * @return string
	 */
	public function encode();

	/**
	 * @param string $token
	 * @return bool
	 */
	public function isEqualTo($token);
} 