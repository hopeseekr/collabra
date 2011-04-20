<?php
/** The Collabra Market Project
  *   Part of the Collabra Commercial Collaboration Platform
  *
  * Copyright(c) 2011 Theodore R. Smith <theodore@phpexperts.pro>
  * Copyright(c) 2011 Monica A. Chase <monica@phpexperts.pro>
  * All rights reserved.
 **/

require_once 'PHPUnit/Framework/TestCase.php';

class CommoditiesExchangeTest extends PHPUnit_Framework_TestCase
{
	/** @var CommodityStore **/
	private $exchange;

	/**
	 * Prepares the environment before running a test.
	 */
	protected function setUp()
	{
		$this->exchange = new CommoditiesExchange;
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
		$commodity = CommoditiesFactory::build($commodityName);
		$basket = new CommoditiesBasket;
		$basket->add($commodity, $quantity);

		return $basket;
	}

	public function testReturnsDifferentialBetweenTwoBaskets()
	{
		$frnBasket1 = $this->createBasket('Federal Reserve Note', 30);
		$frnBasket2 = $this->createBasket('Federal Reserve Note', 15);

		$expectedValue = 15.0;

		$returnedValue = $this->exchange->getValueDifferential($frnBasket1, $frnBasket2);
		$this->assertEquals($expectedValue, $returnedValue);
	}

	public function testCanExchangeTwoCommoditiesReturningFrnAsDifference()
	{
		$silverBasket = $this->createBasket('Silver', 1);
		$frnBasket = $this->createBasket('Federal Reserve Note', 1);

		$frn = CommoditiesFactory::build('Federal Reserve Note');
		$frnStore = new CommodityStore($frn, 44);

		$expectedValue = $frnStore;

		$returnedValue = $this->exchange->exchange($silverBasket, $frnBasket);
		$this->assertEquals($expectedValue, $returnedValue);

	}
}




















