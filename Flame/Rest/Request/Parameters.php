<?php
/**
 * Class Parameters
 *
 * @author: Jiří Šifalda <sifalda.jiri@gmail.com>
 * @date: 07.07.13
 */
namespace Flame\Rest\Request;

use Flame\Rest\Tools\Parser;
use Flame\Rest\Types\ArrayData;
use Nette\Object;

class Parameters extends Object
{
	
	/** @var \Flame\Rest\Types\ArrayData  */
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
		$this->data = new ArrayData($data);
	}

	/**
	 * @return int
	 */
	public function getId()
	{
		return $this->parser->toInt($this->data->getByKey('id'));
	}

	/**
	 * @return string
	 */
	public function getAction()
	{
		return $this->parser->toString($this->data->getByKey('action'));
	}

	/**
	 * @return string
	 */
	public function getFormat()
	{
		return $this->parser->toString($this->data->getByKey('format'));
	}

	/**
	 * @return Association
	 */
	public function getAssociations()
	{
		return new Association($this->data->getByKey('associations', array()));
	}

	/**
	 * @param bool $invalidate
	 * @return mixed
	 */
	public function getData($invalidate = true)
	{
		$data = $this->data->getByKey('data');
		if($data && $invalidate && $this->getFormat() === 'json') {
			$data = $this->parser->parseJson($data);
		}

		return $data;
	}

	/**
	 * @return Query
	 */
	public function getQuery()
	{
		return new Query($this->data->getByKey('query', array()));
	}
}