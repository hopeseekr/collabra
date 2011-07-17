<?php
/**
* User Directory
*   Copyright © 2008 Theodore R. Smith <theodore@phpexperts.pro>
* 
* The following code is licensed under a modified BSD License.
* All of the terms and conditions of the BSD License apply with one
* exception:
*
* 1. Every one who has not been a registered student of the "PHPExperts
*    From Beginner To Pro" course (http://www.phpexperts.pro/) is forbidden
*    from modifing this code or using in an another project, either as a
*    deritvative work or stand-alone.
*
* BSD License: http://www.opensource.org/licenses/bsd-license.php
**/

require_once 'bootstrap.inc.php';
require_once 'PHPUnit/Framework/TestCase.php';

class CommodityStoreTest extends PHPUnit_Framework_TestCase
{
	/** @var CommodityStore **/
	private $commodityStore;
	/**
	 * Prepares the environment before running a test.
	 */
	protected function setUp()
	{
		$commodity = new Commodity();
		$commodity->name = "Test";
		$commodity->currentValuation = 5;
		$commodity->averageValuation = 3.2;

		$this->commodityStore = new CommodityStore($commodity, 5);
		parent::setUp();
	}

	/**
	 * Cleans up the environment after running a test.
	 */
	protected function tearDown()
	{
		parent::tearDown();
	}
	
	/**
	 * Constructs the test case.
	 */
	public function __construct()
	{
	}

	public function testCanStoreACommodity()
	{
		$this->assertInstanceOf('Commodity', $this->commodityStore->commodity);
	}

	public function testCanStoreMultipleQuantities()
	{
		$this->assertEquals(5, $this->commodityStore->quantity);
	}

	public function testCaculatesGrossValuation()
	{
		// 5 quantity * 5 value == 25
		$this->assertEquals(25, $this->commodityStore->calculateWorth());
	}
}

