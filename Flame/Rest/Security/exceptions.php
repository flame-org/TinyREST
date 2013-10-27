<?php

namespace Flame\Rest\Security;

use Nette\Application\BadRequestException;
use Nette\Http\IResponse;
use Nette\Http\Response;

class AuthenticationException extends BadRequestException
{

}

class ForbiddenRequestException extends AuthenticationException
{
	/** @var int */
	protected $defaultCode = Response::S403_FORBIDDEN;
}

class UnauthorizedRequestException extends AuthenticationException
{
	/** @var int */
	protected $defaultCode = IResponse::S401_UNAUTHORIZED;
}

class RequestTimeoutException extends UnauthorizedRequestException
{

}