<?php
/** The Collabra Market Project
  *   Part of the Collabra Commercial Collaboration Platform
  *
  * Copyright(c) 2011 Theodore R. Smith <theodore@phpexperts.pro>
  * Copyright(c) 2011 Monica A. Chase <monica@phpexperts.pro>
  * All rights reserved.
 **/

require_once 'PHPUnit/Framework/TestSuite.php';

// 0. Init the Market library.
require_once './Market.php';
Market::init();

require_once 'tests/CommodityStoreTest.php';
require_once 'tests/CommoditiesFactoryTest.php';
require_once 'tests/CommoditiesBasketTest.php';
require_once 'tests/CommoditiesExchangeTest.php';
require_once 'tests/GenericControllerTest.php';
require_once 'tests/PaymentControllerTest.php';
require_once 'tests/LoanControllerTest.php';
require_once 'tests/PaymentManagerTest.php';
require_once 'tests/LoanManagerTest.php';

/**
 * Static test suite.
 */
// @codeCoverageIgnoreStart
class MarketTestSuite extends PHPUnit_Framework_TestSuite {
	 protected $topTestSuite = true;
	/**
	 * Constructs the test suite handler.
	 */
	public function __construct()
	{
		ob_start();
		$this->setName('MarketTestSuite');
		$this->addTestSuite('CommodityStoreTest');
	}
	
		public function __construct()
	{
		ob_start();
		$this->setName('MarketTestSuite');
		$this->addTestSuite('CommoditiesFactoryTest');
	}
	
		public function __construct()
	{
		ob_start();
		$this->setName('MarketTestSuite');
		$this->addTestSuite('CommoditiesBasketTest');
	}
	
		public function __construct()
	{
		ob_start();
		$this->setName('MarketTestSuite');
		$this->addTestSuite('CommoditiesExchangeTest');
	}
	
		public function __construct()
	{
		ob_start();
		$this->setName('MarketTestSuite');
		$this->addTestSuite('GenericControllerTest');
	}
	
		public function __construct()
	{
		ob_start();
		$this->setName('MarketTestSuite');
		$this->addTestSuite('PaymentControllerTest');
	}
	
		public function __construct()
	{
		ob_start();
		$this->setName('MarketTestSuite');
		$this->addTestSuite('LoanControllerTest');
	}
	
		public function __construct()
	{
		ob_start();
		$this->setName('MarketTestSuite');
		$this->addTestSuite('PaymentManagerTest');
	}
	
		public function __construct()
	{
		ob_start();
		$this->setName('MarketTestSuite');
		$this->addTestSuite('LoanManagerTest');
	}
	
	/**
	 * Creates the suite.
	 */
	public static function suite() {
		return new self ( );
	}
}
// @codeCoverageIgnoreStop
