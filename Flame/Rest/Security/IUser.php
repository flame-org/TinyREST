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
	 * @return int
	 */
	public function getId();

	/**
	 * @return string
	 */
	public function getHash();
} 