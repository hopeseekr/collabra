<?php

/** The Collabra Market Project
  *   Part of the Collabra Commercial Collaboration Platform
  *
  * Copyright(c) 2011 Theodore R. Smith <theodore@phpexperts.pro>
  * All rights reserved.
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

	/**
	 * @covers CommodityStore::__construct
	 **/
	public function testCanStoreACommodity()
	{
		$this->assertInstanceOf('Commodity', $this->commodityStore->commodity);
	}

	/**
	 * @covers CommodityStore::__construct
	 **/
	public function testCanStoreMultipleQuantities()
	{
		$this->assertEquals(5, $this->commodityStore->quantity);
	}

	/**
	 * @covers CommodityStore::calculateWorth
	 **/
	public function testCaculatesGrossValuation()
	{
		// 5 quantity * 5 value == 25
		$this->assertEquals(25, $this->commodityStore->calculateWorth());
	}
}

