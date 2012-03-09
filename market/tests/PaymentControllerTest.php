<?php

/** The Collabra Market Project
  *   Part of the Collabra Commercial Collaboration Platform
  *
  * Copyright(c) 2011 Theodore R. Smith <theodore@phpexperts.pro>
  * All rights reserved.
 **/

require_once 'bootstrap.inc.php';
require_once 'PHPUnit/Extensions/OutputTestCase.php';


/**
 * @covers PaymentController
 **/
class PaymentControllerTest extends PHPUnit_Extensions_OutputTestCase
{
	/** @var PaymentController **/
	private $controller;

	private static $session_id;

	/**
	 * Prepares the environment before running a test.
	 */
	protected function setUp()
	{
		$this->controller = new PaymentController(new PaymentManager);
		if (!headers_sent())
		{
			if (!self::$session_id)
			{
				session_start();
				self::$session_id = session_id();
			}
		}

		ob_start();
		parent::setUp();
	}

	/**
	 * Cleans up the environment after running a test.
	 */
	protected function tearDown()
	{
		ob_clean();
		//session_destroy();
		parent::tearDown();
	}
	
	/**
	 * Constructs the test case.
	 */
	public function __construct()
	{
	}

	public function testWillNotRegisterAPaymentBasketWithoutUserInput()
	{
		try
		{
			$this->controller->execute(ActionsList::CREATE_PAYMENT_BASKET);
			$this->fail('Worked without any user input');
		}
		catch (ControllerException $e)
		{
			$this->assertEquals(ControllerException::INVALID_USER_INPUT, $e->getCode());
		}
	}

	public function testWillRegisterAPaymentBasket()
	{
		// Build the input parameters.
		$_SERVER['REQUEST_METHOD'] = 'post';
		$_POST = array('payment_commodity' => 'Silver',
		               'payment_quantity'  => 1);
	
		// Build the expected value.
		$homePageHTML = grabPageHTML('home');
		$expectedValue = buildPaymentBasket('Silver', 1);
		//$this->expectOutputString($homePageHTML);
	
		$this->controller->execute(ActionsList::CREATE_PAYMENT_BASKET);

		// Make sure the session object has been created and is an array.
		$this->assertTrue(isset($_SESSION['payments']) && is_array($_SESSION['payments']));

		// Make sure the payments array is not empty.
		$this->assertTrue(!empty($_SESSION['payments']));
		$this->assertEquals($expectedValue, $_SESSION['payments'][0], 'oops');

		//file_put_contents(CMARKET_PATH . '/tests/data/payment-xag-1.dat', serialize($_SESSION['payments'])); exit;
	}

	/**
	* @depends testWillRegisterAPaymentBasket
	*/
	public function testMustHaveUserInputToMakeAPayment()
	{
		try
		{
			$this->controller->execute(ActionsList::MAKE_PAYMENT);
			$this->fail('Worked without any user input');
		}
		catch (ControllerException $e)
		{
			$this->assertEquals(ControllerException::INVALID_USER_INPUT, $e->getCode());
		}
	}

	public function testMustHaveARegisteredPaymentBasketToMakeAPayment()
	{
		// Build the input parameters.
		$_SERVER['REQUEST_METHOD'] = 'post';
		$_POST = array('payment_commodity' => 'Silver',
		               'payment_quantity'  => 1);

		try
		{
			$this->controller->execute(ActionsList::MAKE_PAYMENT);
			$this->fail('Worked without a registered payment basket.');
		}
		catch (LogicException $e)
		{
			$this->assertEquals("You must have a registered payment to make a payment.", $e->getMessage());
		}
	}

	public function testMustHaveARegisteredLoanToMakeAPayment()
	{
		// Register the Payment Basket
		$_SERVER['REQUEST_METHOD'] = 'post';
		$_POST = array('payment_commodity' => 'Silver',
		               'payment_quantity'  => 1);

		$this->controller->execute(ActionsList::CREATE_PAYMENT_BASKET);

		try
		{
			$this->controller->execute(ActionsList::MAKE_PAYMENT);
			$this->fail('Worked without a registered loan.');
		}
		catch (LogicException $e)
		{
			$this->assertEquals("You must have a registered loan to make a payment.", $e->getMessage());
		}
	}

	public function testWillMakeAPayment()
	{
		//$this->markTestIncomplete();
		// Register the Payment Basket
		$_SERVER['REQUEST_METHOD'] = 'post';
		$_POST = array('payment_commodity' => 0,
		               'target_loan'       => 0,
		               'loan_quantity'     => 5.5);

		//$this->controller->execute(ActionsList::CREATE_PAYMENT_BASKET);
		$_SESSION['payments'] = unserialize(file_get_contents(CMARKET_PATH . '/tests/data/payment-xag-1.dat'));
		$_SESSION['loans'] = unserialize(file_get_contents(CMARKET_PATH . '/tests/data/loan-frn-50.dat'));
//		print_r($_SESSION); exit;
		//file_put_contents('output.txt', json_encode($_SESSION['payments']));

		$paymentBucket = $_SESSION['payments'][0];
		$loanBucket = $_SESSION['loans'][0]['basket'];
		$expectedValue = $loanBucket->getTotalValuation() - $paymentBucket->getTotalValuation();
		
		// Make sure the session object has been created and is an array.
		$this->assertTrue(isset($_SESSION['payments']) && is_array($_SESSION['payments']));

		// Make sure the payments array is not empty.
		$this->assertTrue(!empty($_SESSION['payments']));

		$this->controller->execute(ActionsList::MAKE_PAYMENT);
		$this->assertTrue(empty($_SESSION['payments']), 'The payment was not removed.');

		$this->assertEquals($expectedValue, $_SESSION['loans'][0]['basket']->getTotalValuation());
	}
}
