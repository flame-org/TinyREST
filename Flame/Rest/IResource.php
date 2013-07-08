<?php
/**
 * Class IResource
 *
 * @author: Jiří Šifalda <sifalda.jiri@gmail.com>
 * @date: 07.07.13
 */

namespace Flame\Rest;


/**
 * IResource determines REST service result set
 * @package Drahak\Restful
 * @author Drahomír Hanák
 */
interface IResource
{

	/** Result types */
	const XML = 'application/xml';
	const JSON = 'application/json';
	const JSONP = 'application/javascript';
	const QUERY = 'application/x-www-form-urlencoded';
	const DATA_URL = 'application/x-data-url';
	const FORM = 'multipart/form-data';
	const NULL = 'NULL';

	/**
	 * Get content type
	 * @return string
	 */
	public function getContentType();

	/**
	 * Set content type
	 * @param string $contentType
	 * @return IResource
	 */
	public function setContentType($contentType);

	/**
	 * Get result set data
	 * @return array|\stdClass|\Traversable
	 */
	public function getData();

	/**
	 * Set result data
	 * @param array $data
	 * @return IResource
	 */
	public function setData(array $data);

}