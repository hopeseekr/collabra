<?php

/** The Collabra Market Project
  *   Part of the Collabra Commercial Collaboration Platform
  *
  * Copyright(c) 2011 Theodore R. Smith <theodore@phpexperts.pro>
  * All rights reserved.
 **/

require_once 'bootstrap.inc.php';
require_once 'PHPUnit/Framework/TestCase.php';

class CommoditiesExchangeTest extends PHPUnit_Framework_TestCase
{
	/** @var CommoditiesExchange **/
	private $broker;

	/**
	 * Prepares the environment before running a test.
	 */
	protected function setUp()
	{
		$this->broker = new CommoditiesExchange;
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

	protected function createBasket($commodityName, $quantity)
	{
		$commodity = CommodityFactory::build($commodityName);
		$basket = new CommodityBasket;
		$basket->add($commodity, $quantity);

		return $basket;
	}

	/**
	 * @covers CommoditiesExchange::getValueDifferential
	 **/
	public function testReturnsDifferentialBetweenTwoBaskets()
	{
		$frnBasket1 = $this->createBasket('Federal Reserve Note', 30);
		$frnBasket2 = $this->createBasket('Federal Reserve Note', 15);

		$expectedValue = 15.0;

		$returnedValue = $this->broker->getValueDifferential($frnBasket1, $frnBasket2);
		$this->assertEquals($expectedValue, $returnedValue);
	}

	/**
	 * @covers CommoditiesExchange::exchange
	 * @covers CommoditiesExchange::handleValueDifference
	 **/
	public function testWillThrowInsufficientFundsOnANegativeBalanceBarterByDefault()
	{
		try
		{
			$silverBasket = $this->createBasket('Silver', 1);
			$frnBasket = $this->createBasket('Federal Reserve Note', 1);
	
			$this->broker->exchange($frnBasket, $silverBasket);
			$this->fail('Did not throw an exception on an unfair barter.');
		}
		catch (CommodityException $e)
		{
			$this->assertEquals($e->getMessage(), "INSUFFICIENT FUNDS: Input is worth less than deliverable.");
		}
	}

	/**
	 * @covers CommoditiesExchange::exchange
	 * @covers CommoditiesExchange::handleValueDifference
	 **/
	public function testCanExchangeTwoCommoditiesReturningFrnAsDifference()
	{
		$silverBasket = $this->createBasket('Silver', 1);
		$frnBasket = $this->createBasket('Federal Reserve Note', 1);

		$valueDifferential = $this->broker->getValueDifferential($silverBasket, $frnBasket);
		//echo "Value Differential: $valueDifferential\n";
		$frn = CommodityFactory::build('Federal Reserve Note');
		$frnStore = new CommodityStore($frn, $valueDifferential);

		$expectedValue = $frnStore;

		$returnedValue = $this->broker->exchange($silverBasket, $frnBasket);
		$this->assertEquals($expectedValue, $returnedValue);

	}

	/**
	 * @covers CommoditiesExchange::exchange
	 * @covers CommoditiesExchange::handleValueDifference
	 **/
	public function testCanExchangeTwoCommoditiesOnCredit()
	{
		$silverBasket = $this->createBasket('Silver', 1);
		$frnBasket = $this->createBasket('Federal Reserve Note', 1);

		$valueDifferential = $this->broker->getValueDifferential($frnBasket, $silverBasket);
		$frn = CommodityFactory::build('Federal Reserve Note');
		$frnStore = new CommodityStore($frn, $valueDifferential);

		$expectedValue = $frnStore;

		$returnedValue = $this->broker->exchange($frnBasket, $silverBasket, CommoditiesExchange::FLAG_ALLOW_DEBT);
		$this->assertEquals($expectedValue, $returnedValue);
	}
}
