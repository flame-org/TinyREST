<?php

namespace Flame\Rest\Security;

use Nette\Application\BadRequestException;

class AuthenticationException extends BadRequestException
{

}

class ForbiddenRequestException extends AuthenticationException
{
	/** @var int */
	protected $defaultCode = 403;
}

class UnauthorizedRequestException extends AuthenticationException
{
	/** @var int */
	protected $defaultCode = 401;
}