<?php
/**
 * Class TokenAuthenticator
 *
 * @author Jiří Šifalda <sifalda.jiri@gmail.com>
 * @date 06.02.14
 */
namespace Flame\Rest\Security\Authenticators;

use Flame\Rest\Security\IHashCalculator;
use Flame\Rest\Security\IUserHash;
use Flame\Rest\Security\Storage\TokenStorage;
use Nette\Http\Response;
use Flame\Rest\Security\RequestTimeoutException;

class TokenAuthenticator extends Authenticator
{

	/** @var  \Flame\Rest\Security\Storage\TokenStorage */
	private $tokenStorage;

	/** @var \Flame\Rest\Security\IUserHash  */
	private $userHash;

	/** @var  \Nette\Http\Response */
	private $httpResponse;

	/** @var \Flame\Rest\Security\HashCalculator  */
	private $hashCalculator;

	/**
	 * @param IHashCalculator $hashCalculator
	 * @param Response $httpResponse
	 * @param TokenStorage $tokenStorage
	 * @param IUserHash $userHash
	 */
	function __construct(IHashCalculator $hashCalculator, Response $httpResponse, TokenStorage $tokenStorage, IUserHash $userHash)
	{
		$this->hashCalculator = $hashCalculator;
		$this->httpResponse = $httpResponse;
		$this->tokenStorage = $tokenStorage;
		$this->userHash = $userHash;
	}

	/**
	 * @return bool
	 */
	public function authRequestData()
	{
		$hash = $this->userHash->getHash();
		if ($this->tokenStorage->isHash($hash)) {
			return false;
		}

		$token = $this->hashCalculator->calculate(TokenStorage::SESSION_KEY);
		$this->tokenStorage->addHash($token);
		$this->httpResponse->addHeader('Authorization', $token);
		return true;
	}

	/**
	 * @return bool
	 * @throws \Flame\Rest\Security\RequestTimeoutException
	 */
	public function authRequestTimeout()
	{
		dump(json_decode($this->userHash->getHash()));exit;
		$pieces = explode(':', $this->userHash->getHash());
		dump($pieces);exit;
		if(isset($pieces[0], $pieces[1])) {
			$expirationTime = new \DateTime();
			$expirationTime->setTimestamp($pieces[1]);

			if((new \DateTime()) > $expirationTime) {
				throw new RequestTimeoutException('Validity of token expired. Please sign in again.');
			}
		}

		return true;
	}

}