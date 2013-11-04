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
		return new Parameters($this->createData($params));
	}

	/**
	 * @param array $default
	 * @return array
	 */
	public function createData(array $default)
	{
		if(!isset($default['data']) || !$default['data']) {
			$default['data'] = $this->httpRequest->getPost();
		}

		if($default['format'] !== 'json') {
			$default['data'] = $this->formatData($default['data']);
		}

		return $default;
	}

	/**
	 * @param mixed $data
	 * @return mixed
	 */
	private function formatData($data)
	{
		if(is_string($data) && strpos($data, '=') !== false) {
			if(strpos($data, '&') !== false) {
				$data = explode('&', $data);
			}

			if(!is_array($data)) {
				$data = array($data);
			}

			if(count($data)) {
				$newData = array();
				foreach ($data as $item) {
					$item = explode('=', $item);
					if(isset($item[0], $item[1])) {
						$newData[$item[0]] = $item[1];
					}
				}

				$data = $newData;
			}
		}

		return $data;
	}

} 