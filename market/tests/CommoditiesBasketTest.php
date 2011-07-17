<?php

/** The Collabra Market Project
  *   Part of the Collabra Commercial Collaboration Platform
  *
  * Copyright(c) 2011 Theodore R. Smith <theodore@phpexperts.pro>
  * All rights reserved.
 **/

require_once 'bootstrap.inc.php';

require_once 'PHPUnit/Framework/TestCase.php';

class CommoditiesBasketTest extends PHPUnit_Framework_TestCase
{
	/** @var CommoditiesBasket **/
	private $basket;
	/**
	 * Prepares the environment before running a test.
	 */
	protected function setUp()
	{
		$this->basket = new CommoditiesBasket;
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

	/** @return Commodity **/
	protected function makeACommodity($name = "Test Commodity", $cv = 1.5, $av = 1.5)
	{
		$commodity = new Commodity;
		$commodity->name = $name;
		$commodity->currentValuation = $cv;
		$commodity->averageValuation = $av;

		return $commodity;
	}

	/**
	 * @covers CommoditiesBasket::__construct
	 **/
	public function testStartsOutEmpty()
	{
		$this->assertAttributeEquals(null, 'commoditiesQueue', $this->basket);
	}

	/**
	 * @covers CommoditiesBasket::getMeasureName
	 **/
	public function testCanRetrieveNameOfCommodityMeasure()
	{
		$this->assertEquals('Federal Reserve Note', $this->basket->getMeasureName());
	}

	/**
	 * @covers CommoditiesBasket::add
	 **/
	public function testCanAddACommodity()
	{
		$commodity = $this->makeACommodity();

		$this->basket->add($commodity, 2);

		// Make sure that only one item has been added, with quantity of 2.
		$expectedResults = array($commodity->name => new CommodityStore($commodity, 2));
		$this->assertAttributeEquals($expectedResults, 'commoditiesQueue', $this->basket);
	}

	/**
	 * @covers CommoditiesBasket::add
	 **/
	public function testWillAddOneCommodityByDefault()
	{
		$commodity = $this->makeACommodity();

		$this->basket->add($commodity);

		// Make sure that only one item has been added, with quantity of 1.
		$expectedResults = array($commodity->name => new CommodityStore($commodity, 1));
		$this->assertAttributeEquals($expectedResults, 'commoditiesQueue', $this->basket);
	}

	/**
	 * @covers CommoditiesBasket::add
	 **/
	public function testCannotAddACommodityWithAnNonNumericQuantity()
	{
		$commodity = $this->makeACommodity();
		try
		{
			$this->basket->add($commodity, 'Non-Numeric Quantity');
			$this->fail('Accepted an invalid quantity.');
		}
		catch(InvalidArgumentException $e)
		{
			$this->assertEquals("Quantity must be numerical.", $e->getMessage());
		}
	}

	/**
	 * @covers CommoditiesBasket::add
	 **/
	public function testAddingTheSameCommodityWillIncreaseItsQuantity()
	{
		$commodity = $this->makeACommodity();

		$this->basket->add($commodity);
		$this->basket->add($commodity, 2);

		// Make sure that only one item has been added, with quantity of 1.
		$expectedResults = array($commodity->name => new CommodityStore($commodity, 3));
		$this->assertAttributeEquals($expectedResults, 'commoditiesQueue', $this->basket);
	}

	/**
	 * @covers CommoditiesBasket::add
	 **/
	public function testMultipleCommoditiesCanBeAdded()
	{
		$commodity = $this->makeACommodity();
		$commodity2 = $this->makeACommodity('Test 2', 2, 2);

		$this->basket->add($commodity);
		$this->basket->add($commodity2, 2);

		// Make sure that only one item has been added, with quantity of 1.
		$expectedResults = array($commodity->name => new CommodityStore($commodity, 1),
		                         $commodity2->name => new CommodityStore($commodity2, 2));
		$this->assertAttributeEquals($expectedResults, 'commoditiesQueue', $this->basket);
	}

	/**
	 * @covers CommoditiesBasket::take
	 **/
	public function testTakingFromAnEmptyBasketWontWork()
	{
		try
		{
			$this->basket->take();
			$this->fail('Tried to take an item from an empty basket.');
		}
		catch (CommodityException $e)
		{
			$this->assertEquals($e->getMessage(), "Your basket is empty");
		}
	}

	/**
	 * @covers CommoditiesBasket::take
	 **/
	public function testTakesFirstCommodityFromTheBasket()
	{
		// Add two things to the Basket.
		$this->testMultipleCommoditiesCanBeAdded();

		// Set up the test data.
		$commodity = $this->makeACommodity();
		$expectedCommodityStore = new CommodityStore($commodity, 1);

		// Confirm it's the right commodity store.
		$commodityStore = $this->basket->take();
		$this->assertEquals($expectedCommodityStore, $commodityStore);

		// Confirm the commodity store has been removed from the Basket.
		$commodity2 = $this->makeACommodity('Test 2', 2, 2);
		$expectedResults = array($commodity2->name => new CommodityStore($commodity2, 2));
		$this->assertAttributeEquals($expectedResults, 'commoditiesQueue', $this->basket);
	}

	/**
	 * @covers CommoditiesBasket::fetchCommodity
	 **/
	public function testCanRetrieveASpecificCommodity()
	{
		// Add two things to the Basket.
		$this->testMultipleCommoditiesCanBeAdded();

		// Set up the test data.
		$commodity = $this->makeACommodity();
		$expectedCommodityStore = new CommodityStore($commodity, 1);

		// Confirm it's the right commodity store.
		$commodityStore = $this->basket->fetchCommodity($commodity->name);
		$this->assertEquals($expectedCommodityStore, $commodityStore);
	}

	/**
	 * @covers CommoditiesBasket::fetchCommodity
	 **/
	public function testWillThrowExceptionOnMissingCommodity()
	{
		try
		{
			$this->basket->fetchCommodity('Unknown commodity');
			$this->fail('Tried to fetch an unknown commodity.');
		}
		catch(CommodityException $e)
		{
			$this->assertEquals("Commodity Not Found", $e->getMessage());
		}
	}

	/**
	 * @covers CommoditiesBasket::getTotalValuation
	 **/
	public function testReturnsZeroWorthForEmptyBaskets()
	{
		$value = $this->basket->getTotalValuation();
		$this->assertEquals(0, $value);
	}

	/**
	 * @covers CommoditiesBasket::getTotalValuation
	 **/
	public function testReturnsProperWorthOfACommodity()
	{
		// Add one thing to the Basket.
		$commodity = $this->makeACommodity();
		$this->basket->add($commodity, 3);

		// Set up the test data.
		$commodityStore = new CommodityStore($commodity, 3);
		$expectedValue = $commodityStore->calculateWorth();

		// Confirm it's the right commodity store.
		$value = $this->basket->getTotalValuation();
		$this->assertEquals($expectedValue, $value);

	}

	/**
	 * @covers CommoditiesBasket::getTotalValuation
	 **/
	public function testCanBeMeasuredInAnyCommodity()
	{
		$this->markTestIncomplete();
		$FRNs = CommoditiesFactory::build('Federal Reserve Note');

		$silver = CommoditiesFactory::build('Silver');
		$silver->currentValuation = 50;
		$this->basket = new CommoditiesBasket($silver);
		$this->basket->add($FRNs, 10);

		$expectedValue = 40;

		$this->assertEquals($expectedValue, $this->basket->getTotalValuation());
	}

	/**
	 * @covers CommoditiesBasket::dumpStats
	 **/
	public function testWillAccuratelyReturnStatistics()
	{
		// Add two things to the Basket.
		$this->testMultipleCommoditiesCanBeAdded();

		// Set up the test data.
		$expectedStats[] = array('name'      => 'Test Commodity',
		                         'valuation' => 1.5,
		                         'quantity'  => 1,
		                         'subtotal'  => 1.5);

		$expectedStats[] = array('name'      => 'Test 2',
		                         'valuation' => 2,
		                         'quantity'  => 2,
		                         'subtotal'  => 4.0);
		$this->assertEquals($expectedStats, $this->basket->dumpStats());
	}
}

