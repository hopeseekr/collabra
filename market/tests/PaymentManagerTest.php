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

	// TODO: Migrate over to a CommoditiesFactory::buildBasket() factory.
	protected function buildPaymentBasket($commodityName, $quantity)
	{
		$commodity = CommoditiesFactory::build($commodityName);
		$basket = new CommoditiesBasket;
		$basket->add($commodity, $quantity);

		return $basket;
	}

	/**
	* @group PaymentManager::buildPaymentBasket
	*/
	public function testWillNotBuildABasketWithAnInvalidCommodityName()
	{
		try
		{
			$this->bookie->buildPaymentBasket(1234, 1);
			$this->fail('Built a basket using an invalid commodity name');
		}
		catch (InvalidArgumentException $e)
		{
			$this->assertEquals($e->getMessage(), "Commodity Name must be a string");
		}
	}

	/**
	* @group PaymentManager::buildPaymentBasket
	*/
	public function testWillNotBuildABasketWithAnInvalidQuantity()
	{
		try
		{
			$this->bookie->buildPaymentBasket('Silver', 'string');
			$this->fail('Built a basket using an invalid quantity');
		}
		catch (InvalidArgumentException $e)
		{
			$this->assertEquals($e->getMessage(), "Quantity must be a float");
		}
	}

	/**
	* @group PaymentManager::buildPaymentBasket
	*/
	public function testWillNotBuildABasketWithAEqualToOrLesserThanZeroQuantity()
	{
		try
		{
			$this->bookie->buildPaymentBasket('Silver', 0);
			$this->fail('Built a basket using quantity equal to 0.');
		}
		catch (OutOfBoundsException $e)
		{
			$this->assertEquals($e->getMessage(), "The payment commodity quantity must be more than 0.");
		}

		try
		{
			$this->bookie->buildPaymentBasket('Silver', -5);
			$this->fail('Built a basket using quantity less than 0.');
		}
		catch (OutOfBoundsException $e)
		{
			$this->assertEquals($e->getMessage(), "The payment commodity quantity must be more than 0.");
		}
	}

	/**
	* @group PaymentManager::buildPaymentBasket
	*/
	public function testWillBuildACommoditiesBasket()
	{
		$expectedValue = $this->buildPaymentBasket('Silver', 5);
		$returnedValue = $this->bookie->buildPaymentBasket('Silver', 5);

		$this->assertEquals($expectedValue, $returnedValue);
	}

	/**
	* @group PaymentManager::handlePaymentTransaction
	*/
	public function testWillNotAcceptNegativePayments()
	{
		$paymentBasket = $this->buildPaymentBasket('Silver', -5);

		//$loanBasket = $this->buildPaymentBasket('FRN', 1);
		$lender = new LoanManager();
		$loan = $lender->buildLoan('FRN', 30, 15, 0.05);

		try
		{
			$this->bookie->handlePaymentTransaction($paymentBasket, $loan, 1);
			$this->fail('Accepted a negative payment.');
		}
		catch (OutOfBoundsException $e)
		{
			// TODO: Move to the PrettyException model.
			$this->assertEquals("The payment commodity amount must be more than 0.", $e->getMessage());
		}
	}

	public function testWillReturnAnAppropriatelyDeductedLoanObject()
	{
		$frnValue = 120;
		$paymentBasket = $this->buildPaymentBasket('Silver', 1);

		//$loanBasket = $this->buildPaymentBasket('FRN', 1);
		$lender = new LoanManager();
		$loan = $lender->buildLoan('FRN', $frnValue, 15, 0.05);
		$expectedValue = $frnValue - $paymentBasket->getTotalValuation();

		$modifiedLoan = $this->bookie->handlePaymentTransaction($paymentBasket, $loan, 1);
		$this->assertInternalType('array', $modifiedLoan);
		$this->assertArrayHasKey('basket', $modifiedLoan);

		$loanBasket = $modifiedLoan['basket'];
		$this->assertEquals($expectedValue, $loanBasket->getTotalValuation(), 'Returned an unexpected valuation.');
	}
}

