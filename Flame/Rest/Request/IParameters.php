<?php
/**
 * Class IParameters
 *
 * @author: Jiří Šifalda <sifalda.jiri@gmail.com>
 * @date: 26.10.13
 */
namespace Flame\Rest\Request;

interface IParameters
{
	/**
	 * @return int
	 */
	public function getId();

	/**
	 * @return string
	 */
	public function getAction();

	/**
	 * @return string
	 */
	public function getFormat();

	/**
	 * @return array|\Nette\Http\FileUpload[]
	 */
	public function getFiles();

	/**
	 * @param null|string $name
	 * @param null $default
	 * @return mixed
	 */
	public function getAssociations($name = null, $default = null);

	/**
	 * @param null|string $name
	 * @param null $default
	 * @return mixed
	 */
	public function getData($name = null, $default = null);

	/**
	 * @param null|string $query
	 * @param null $default
	 * @return mixed
	 */
	public function getQuery($query = null, $default = null);
} 