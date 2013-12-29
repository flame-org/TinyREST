<?php
/**
 * Class Files
 *
 * @author Jiří Šifalda <sifalda.jiri@gmail.com>
 * @date 29.12.13
 */
namespace Flame\Rest\Http;

use Nette\Http\FileUpload;
use Nette\Object;

class Files extends Object
{

	/** @var array|FileUpload[]  */
	private $files = array();

	/**
	 * @param null $files
	 */
	public function __construct($files = null)
	{
		if ($files === null) {
			$files = $_FILES;
		}

		if (count($files)) {
			foreach ($files as &$file) {
				$this->files[] = new FileUpload($file);
			}
		}
	}

	/**
	 * @return array|\Nette\Http\FileUpload[]
	 */
	public function getFiles()
	{
		return $this->files;
	}

} 