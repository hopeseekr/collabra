<?php
/** The Collabra Market Project
  *   Part of the Collabra Commercial Collaboration Platform
  *
  * Copyright(c) 2011 Theodore R. Smith <theodore@phpexperts.pro>
  * Copyright(c) 2011 Monica A. Chase <monica@phpexperts.pro>
  * All rights reserved.
 **/

require_once 'PHPUnit/Extensions/OutputTestCase.php';

class PaymentControllerTest extends PHPUnit_Extensions_OutputTestCase
{
	/** @var CommodityStore **/
	private $controller;

	private static $session_id;

	/**
	 * Prepares the environment before running a test.
	 */
	protected function setUp()
	{
		$this->controller = new PaymentController;

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
		if (!headers_sent())
		{
			if (!self::$session_id)
			{
				session_start();
				self::$session_id = session_id();
			}
		}

	}

	protected function grabPageHTML($page)
	{
		$filename = CMARKET_LIB_PATH . '/views/' . $page  . '.tpl.php';
		if (!file_exists($filename))
		{
			$this->assert(false, "Template file $page.tpl.php not found.");
		}

		ob_start();
		include $filename;
		$html = ob_get_clean();

		return $html;
	}

	protected function buildPaymentBasket($commodityName, $quantity)
	{
		$commodity = CommoditiesFactory::build($commodityName);
		$basket = new CommoditiesBasket($commodity, $quantity);

		return $basket;
	}

	public function testWillShowHomePageByDefault()
	{
		$homePageHTML = $this->grabPageHTML('home');
		$this->expectOutputString($homePageHTML);
		$this->controller->execute("UNKNOWN ACTION");
	}

	public function testWillShowMonicasBoobsToTheo()
	{
		// This goes to false if it doesn't actually happen ;p
		$this->assertTrue(true);
	}

	public function testWillCreateAPaymentBasket()
	{
		// Build the input parameters.
		$_SERVER['REQUEST_METHOD'] = 'post';
		$_POST = array('payment_commodity' => 'Silver',
		               'payment_quantity'  => 1);
	
		// Build the expected value.
		$homePageHTML = $this->grabPageHTML('home');
		$expectedValue = $this->buildPaymentBasket('Silver', 1);
		$this->expectOutputString($homePageHTML);
	
		$this->controller->execute(ActionsList::CREATE_PAYMENT_BASKET);

		// Make sure the session object has been created and is an array.
		$this->assertTrue(isset($_SESSION['payments']) && is_array($_SESSION['payments']));

		// Make sure the payments array is not empty.
		$this->assertTrue(!empty($_SESSION['payments']));

		$this->assertEquals($expectedValue, $_SESSION['payments'][0]);
	}

	public function testWillMakeAPayment()
	{
		// We're currently testing the PaymentController, but MakeAPayment
		// requires PaymentManager to work. So this means that we either have
		// to unit test PaymentManager first or make the code less brittle.
		// Which do you prefer? unit test PaymentManager.
	}
}



















