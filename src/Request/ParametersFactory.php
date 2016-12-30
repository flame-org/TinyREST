<?php
/**
 * Class ParametersFactory
 *
 * @author: Jiří Šifalda <sifalda.jiri@gmail.com>
 * @date: 26.10.13
 */
namespace Flame\Rest\Request;

use Nette\Http\Request;
use Nette\Object;
use Nette\Utils\Json;

class ParametersFactory extends Object implements IParametersFactory
{

	/** @var \Nette\Http\Request  */
	private $httpRequest;

	/**
	 * @param Request $httpRequest
	 */
	function __construct(Request $httpRequest)
	{
		$this->httpRequest = $httpRequest;
	}

	/**
	 * @param array $params
	 * @return Parameters
	 */
	public function create(array $params = array())
	{
		return new Parameters($this->createData($params), $_FILES);
	}

	/**
	 * @param array $default
	 * @return array
	 */
	public function createData(array $default)
	{
		if(!isset($default['data']) || !$default['data']) {
			$default['data'] = $this->readData();
		}

		if (is_string($default['data'])) {
			$default['data'] = Json::decode((string) $default['data'], JSON_HEX_TAG);
		}

		return $default;
	}

	/**
	 * @return mixed|string
	 */
	protected function readData()
	{
		$data = $this->readInput();
		if(!$data) {
			$data = $this->httpRequest->getPost();
		}

		return $data;
	}

	/**
	 * @return string
	 */
	protected function readInput()
	{
		return file_get_contents('php://input');
	}

}
