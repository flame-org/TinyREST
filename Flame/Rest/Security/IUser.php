<?php
/**
 * Class IUser
 *
 * @author: Jiří Šifalda <sifalda.jiri@gmail.com>
 * @date: 26.10.13
 */
namespace Flame\Rest\Security;

interface IUser
{

	/**
	 * @return string
	 */
	public function getHash();

	/**
	 * @param IToken $token
	 * @return $this
	 */
	public function setHash(IToken $token);
} 