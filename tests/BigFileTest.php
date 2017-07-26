<?php

namespace Tests;

use \AdService\BigFile;
use \PHPUnit\Framework\TestCase;

 /**
  * @runTestsInSeparateProcesses
  */

class BigFileTest extends TestCase
    {

	/**
	 * Prepare data for testing
	 *
	 * @return void
	 */

	public function setUp()
	    {
		if (file_exists("/home/bigfiles/storage") === true)
		    {
			unlink("/home/bigfiles/storage");
		    }

		if (file_exists(__DIR__ . "/testdir/storage") === true)
		    {
			unlink(__DIR__ . "/testdir/storage");
		    }

		if (file_exists(__DIR__ . "/testdir") === true)
		    {
			rmdir(__DIR__ . "/testdir");
		    }

		parent::setUp();
	    } //end setUp()


	/**
	 * Destroy testing data
	 *
	 * @return void
	 */

	public function tearDown()
	    {
		if (file_exists("/home/bigfiles/storage") === true)
		    {
			unlink("/home/bigfiles/storage");
		    }

		if (file_exists(__DIR__ . "/testdir/storage") === true)
		    {
			unlink(__DIR__ . "/testdir/storage");
		    }

		if (file_exists(__DIR__ . "/testdir") === true)
		    {
			rmdir(__DIR__ . "/testdir");
		    }

		parent::tearDown();
	    } //end setUp()


	/**
	 * Should add new record to file
	 *
	 * @return void
	 */

	public function testShouldAddNewRecordToFile()
	    {
		$bigfile = new BigFile("storage", 11);

		$bigfile->addRecord("89526191914");
		$bigfile->addRecord("89149399500");

		$records = $bigfile->getRecords();
		$this->assertEquals("89526191914", $records[0]);
		$this->assertEquals("89149399500", $records[1]);
	    } //end testShouldAddNewRecordToFile()


	/**
	 * Should write data to file if defined constant BIG_FILE_DIR
	 *
	 * @return void
	 */

	public function testShouldWriteDataToFileIfDefinedConstantBigfiledir()
	    {
		$testdir = __DIR__ . "/testdir";
		define("BIG_FILE_DIR", $testdir);

		$bigfile = new BigFile("storage", 11);

		$bigfile->addRecord("89526191914");
		$bigfile->addRecord("89149399500");

		$records = $bigfile->getRecords();
		$this->assertEquals("89526191914", $records[0]);
		$this->assertEquals("89149399500", $records[1]);
		$this->assertTrue(file_exists($testdir));
	    } //end testShouldWriteDataToFileIfDefinedConstantBigfiledir()


	/**
	 * Should update record by index
	 *
	 * @return void
	 */

	public function testShouldUpdateRecordByIndex()
	    {
		$bigfile = new BigFile("storage", 11);

		$bigfile->addRecord("89526191914");
		$bigfile->addRecord("89149399500");

		$records = $bigfile->getRecords();
		$this->assertEquals("89526191914", $records[0]);
		$this->assertEquals("89149399500", $records[1]);

		$bigfile->update(1, "89998887766");

		$records = $bigfile->getRecords();
		$this->assertEquals("89526191914", $records[0]);
		$this->assertEquals("89998887766", $records[1]);
	    } //end testShouldUpdateRecordByIndex()


	/**
	 * Should get record by index
	 *
	 * @return void
	 */

	public function testShouldGetRecordByIndex()
	    {
		$bigfile = new BigFile("storage", 11);

		$bigfile->addRecord("89526191914");
		$bigfile->addRecord("89149399500");

		$this->assertEquals("89526191914", $bigfile->getrecord(0));
		$this->assertEquals("89149399500", $bigfile->getrecord(1));
	    } //end testShouldGetRecordByIndex()


    } //end class

?>
