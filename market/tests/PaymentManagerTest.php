<?php

/** The Collabra Market Project
  *   Part of the Collabra Commercial Collaboration Platform
  *
  * Copyright(c) 2011 Theodore R. Smith <theodore@phpexperts.pro>
  * All rights reserved.
 **/

require_once 'bootstrap.inc.php';
require_once 'PHPUnit/Framework/TestCase.php';

class PaymentManagerTest extends PHPUnit_Framework_TestCase
{
	/** @var PaymentManager **/
	private $bookie;

	/**
	 * Prepares the environment before running a test.
	 */
	protected function setUp()
	{
		$this->bookie = new PaymentManager;

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

    protected function buildPaymentBasket($commodityName, $quantity)
    {
        $commodity = CommoditiesFactory::build($commodityName);
        $basket = new CommoditiesBasket;
		$basket->add($commodity, $quantity);

        return $basket;
    }

	public function testWillNotBuildABasketWithAnInvalidCommodityName()
	{
		try
		{
			$this->bookie->buildPaymentBasket(1234, 1);
			$this->assertTrue(false, 'Built a basket using an invalid commodity name');
		}
		catch (InvalidArgumentException $e)
		{
			if ($e->getMessage() != "Commodity Name must be a string")
			{
				$this->assertTrue(false, 'Returned an unexpected exception message');
			}
		}
	}

	public function testWillNotBuildABasketWithAnInvalidQuantity()
	{
		try
		{
			$this->bookie->buildPaymentBasket('Silver', 'string');
			$this->assertTrue(false, 'Built a basket using an invalid quantity');
		}
		catch (InvalidArgumentException $e)
		{
			if ($e->getMessage() != "Quantity must be a float")
			{
				$this->assertTrue(false, 'Returned an unexpected exception message');
			}
		}
	}

	public function testWillNotBuildABasketWithAEqualToOrLesserThanZeroQuantity()
	{
		try
		{
			$this->bookie->buildPaymentBasket('Silver', 0);
			$this->assertTrue(false, 'Built a basket using quantity equal to 0.');
		}
		catch (OutOfBoundsException $e)
		{
			if ($e->getMessage() != "The payment commodity quantity must be more than 0.")
			{
				$this->assertTrue(false, 'Returned an unexpected exception message');
			}
		}

		try
		{
			$this->bookie->buildPaymentBasket('Silver', -5);
			$this->assertTrue(false, 'Built a basket using quantity less than 0.');
		}
		catch (OutOfBoundsException $e)
		{
			if ($e->getMessage() != "The payment commodity quantity must be more than 0.")
			{
				$this->assertTrue(false, 'Returned an unexpected exception message');
			}
		}
	}

	public function testWillBuildACommoditiesBasket()
	{
		$expectedValue = $this->buildPaymentBasket('Silver', 5);
		$returnedValue = $this->bookie->buildPaymentBasket('Silver', 5);

		$this->assertEquals($expectedValue, $returnedValue);
	}

	public function testWillThrowInsufficientFundsOnUnequalBarter()
	{
		try
		{
			$paymentBasket = $this->buildPaymentBasket('Silver', 1);
			$loanBasket = $this->buildPaymentBasket('Federal Reserve Note', 100);
	
			$frn = $this->bookie->handlePaymentTransaction($paymentBasket, $loanBasket, 1);
		}
		catch (CommodityException $e)
		{
			if ($e->getMessage() != "INSUFFICIENT FUNDS: Input is worth less than deliverable.")
			{
				$this->assertTrue(false, 'Returnded an unexpected exception message.');
			}
		}
	}
}
