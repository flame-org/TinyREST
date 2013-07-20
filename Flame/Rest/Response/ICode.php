<?php
/**
 * Class IResponse
 *
 * @author: Jiří Šifalda <sifalda.jiri@gmail.com>
 * @date: 07.07.13
 */
namespace Flame\Rest\Response;

interface ICode
{
	const
		S200_OK = 200,
		S204_NO_CONTENT = 204,
		S300_MULTIPLE_CHOICES = 300,
		S301_MOVED_PERMANENTLY = 301,
		S302_FOUND = 302,
		S303_SEE_OTHER = 303,
		S303_POST_GET = 303,
		S304_NOT_MODIFIED = 304,
		S307_TEMPORARY_REDIRECT= 307,
		S400_BAD_REQUEST = 400,
		S401_UNAUTHORIZED = 401,
		S403_FORBIDDEN = 403,
		S404_NOT_FOUND = 404,
		S405_METHOD_NOT_ALLOWED = 405,
		S410_GONE = 410,
		S500_INTERNAL_SERVER_ERROR = 500,
		S501_NOT_IMPLEMENTED = 501,
		S503_SERVICE_UNAVAILABLE = 503;

	/**
	 * Return list of defined status codes
	 *
	 * @return array
	 */
	public function getCodes();

}