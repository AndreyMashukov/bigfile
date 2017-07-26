<?php

namespace AdService;

class BigFile
    {

	/**
	 * Size of record
	 *
	 * @var int
	 */
	private $_recordsize;

	/**
	 * Filename
	 *
	 * @var string
	 */
	private $_filename;

	/**
	 * Construct object
	 *
	 * @param string $filename   Filename
	 * @param int    $recordsize Size of record
	 *
	 * @return void
	 */

	public function __construct(string $filename, int $recordsize)
	    {
		$this->_recordsize = $recordsize;
		if (defined("BIG_FILE_DIR") === true)
		    {
			$dir = BIG_FILE_DIR;
		    }
		else
		    {
			$dir = "/home/bigfiles";
		    } //end if

		if (file_exists($dir) === false)
		    {
			mkdir($dir);
		    }

		$this->_filename = $dir . "/" . $filename;
	    } //end __construct()


	/**
	 * Add new record to file
	 *
	 * @param string $string Data string
	 *
	 * @return void
	 */

	public function addrecord(string $string)
	    {
		$string = substr($string, 0, $this->_recordsize);
		$string = str_pad($string, $this->_recordsize, chr(0));
		$file   = fopen($this->_filename, "a");
		fwrite($file, $string);
		fclose($file);
	    } //end addrecord()


	/**
	 * Get record by index
	 *
	 * @param int $n Index of record
	 *
	 * @return string Record
	 */

	public function getrecord(int $n):string
	    {
		$pos  = $n * $this->_recordsize;
		$file = fopen($this->_filename, "r");
		fseek($file, $pos);
		$string = fread($file, $this->_recordsize);
		fclose($file);
		return $string;
	    } //end getrecord()


	/**
	 * Update record by index
	 *
	 * @param int    $n      Index of record
	 * @param string $string New record string
	 *
	 * @return void
	 */

	public function update($n, $string)
	    {
		$string = substr($string, 0, $this->_recordsize);
		$string = str_pad($string, $this->_recordsize, chr(0));
		$file   = fopen($this->_filename, "c");
		flock($file, LOCK_EX);
		$pos    = $n * $this->_recordsize;
		fseek($file, $pos);
		fwrite($file, $string);
		fclose($file);
	    } //end update()


	/**
	 * Get all records
	 *
	 * @return array With records
	 */

	public function getRecords():array
	    {
		$records = array();

		$n = 0;
		if (file_exists($this->_filename) === false)
		    {
			return array();
		    }

		$file = fopen($this->_filename, "r");

		while (true)
		    {
			$pos = $n * $this->_recordsize;
			fseek($file, $pos);
			$res = fread($file, $this->_recordsize);
			if (mb_strlen($res) === 0)
			    {
				break;
			    }

			$records[] = $res;
			$n++;
		    }

		fclose($file);

		return $records;
	    } //end getRecords()


    } //end class

?>
