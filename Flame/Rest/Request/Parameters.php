<?php
/**
 * Class Parameters
 *
 * @author: Jiří Šifalda <sifalda.jiri@gmail.com>
 * @date: 07.07.13
 */
namespace Flame\Rest\Request;

use Flame\Rest\Tools\Parser;
use Nette\ArrayHash;
use Nette\Object;

class Parameters extends Object
{
	
	/** @var \Nette\ArrayHash  */
	private $data;

	/** @var \Flame\Rest\Tools\Parser  */
	private $parser;

	/**
	 * @param Parser $parser
	 * @param array $data
	 */
	function __construct(Parser $parser, array $data)
	{
		$this->parser = $parser;
		$this->data = ArrayHash::from($data);
	}

	/**
	 * @return int
	 */
	public function getId()
	{
		return $this->parser->toInt($this->data->id);
	}

	/**
	 * @return string
	 */
	public function getAction()
	{
		return $this->parser->toString($this->data->action);
	}

	/**
	 * @return string
	 */
	public function getFormat()
	{
		return $this->parser->toString($this->data->format);
	}

	/**
	 * @return ArrayHash
	 */
	public function getAssociations()
	{
		return ArrayHash::from($this->data->associations);
	}

	/**
	 * @param bool $invalidate
	 * @return mixed
	 */
	public function getData($invalidate = true)
	{
		$data = $this->data->data;
		if($data && $invalidate && $this->getFormat() === 'json') {
			$data = ArrayHash::from($this->parser->parseJson($data));
		}

		return $data;
	}

	/**
	 * @return ArrayHash
	 */
	public function getQuery()
	{
		return ArrayHash::from($this->data->query);
	}
}