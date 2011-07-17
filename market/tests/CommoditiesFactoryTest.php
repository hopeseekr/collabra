<?php

/** The Collabra Market Project
  *   Part of the Collabra Commercial Collaboration Platform
  *
  * Copyright(c) 2011 Theodore R. Smith <theodore@phpexperts.pro>
  * All rights reserved.
 **/

require_once 'bootstrap.inc.php';
require_once 'PHPUnit/Framework/TestCase.php';

class CommoditiesFactoryTest extends PHPUnit_Framework_TestCase
{
	/**
	 * Prepares the environment before running a test.
	 */
	protected function setUp()
	{
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

	protected function makeSilverCommodity()
	{
		$silver = new Commodity;
		$silver->name = "Silver";
		$silver->type = "precious metal";
		$silver->currentValuation = 45.00;
		$silver->averageValuation = 20.00;

		$silverSpecs = new StorageSpecs;
		$silverSpecs->isVirtual = false;
		$silverSpecs->weight = 31.1035;
		$silverSpecs->dimensions = array('width' => 5, 'height' => 5, 'depth' => 0.1);
		$silverSpecs->fragility = 30.00;
		$silverSpecs->toxicity = 0.00;
		$silverSpecs->expiresAfter = "0000-00-00 00:00:00";

		$silver->storageSpecs = $silverSpecs;

		return $silver;
	}

	/**
	 * @covers CommoditiesFactory::build
	 **/
	public function testCannotBuildUnknownCommodities()
	{
		$badCommodity = 'Bad Commodity 22233';
		try
		{
			CommoditiesFactory::build($badCommodity);
			$this->fail('Attempted to build an unknown commodity.');
		}
		catch (CommodityException $e)
		{
			$this->assertEquals($e->getMessage(), "No build process for a commodity called " . $badCommodity);
		}
	}

	/**
	 * @covers CommoditiesFactory::build
	 **/
	public function testWillSuccessfullyBuildKnownCommodities()
	{
		$expectedResult = $this->makeSilverCommodity();

		$result = CommoditiesFactory::build('Silver');
		$this->assertEquals($expectedResult, $result);

		$result = CommoditiesFactory::build('Federal Reserve Note');
		$this->assertEquals('Federal Reserve Note', $result->name);
	}
}



















