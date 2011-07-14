<?php

/** The Collabra Market Project
  *   Part of the Collabra Commercial Collaboration Platform
  *
  * Copyright(c) 2011 Theodore R. Smith <theodore@phpexperts.pro>
  * All rights reserved.
 **/

require_once 'PHPUnit/Framework/TestSuite.php';

// 0. Init the Market library.
require_once 'bootstrap.inc.php';

require_once CMARKET_LIB_PATH . '/tests/CommodityStoreTest.php';
require_once CMARKET_LIB_PATH . '/tests/CommoditiesFactoryTest.php';
require_once CMARKET_LIB_PATH . '/tests/CommoditiesBasketTest.php';
require_once CMARKET_LIB_PATH . '/tests/CommoditiesExchangeTest.php';
require_once CMARKET_LIB_PATH . '/tests/GenericControllerTest.php';
require_once CMARKET_LIB_PATH . '/tests/PaymentControllerTest.php';
require_once CMARKET_LIB_PATH . '/tests/LoanControllerTest.php';
require_once CMARKET_LIB_PATH . '/tests/PaymentManagerTest.php';
require_once CMARKET_LIB_PATH . '/tests/LoanManagerTest.php';

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

        // Ignore libraries code coverage.
        $coverageFilter = PHP_CodeCoverage_Filter::getInstance();
        $coverageFilter->addDirectoryToBlacklist(COLLABRA_PATH . '/lib');
        
		// Test Datatypes.
		$this->addTestSuite('CommodityStoreTest');

		// Test core commodity responsibilities.
		$this->addTestSuite('CommoditiesBasketTest');
		$this->addTestSuite('CommoditiesFactoryTest');
		$this->addTestSuite('CommoditiesExchangeTest');

		// Test the managers.
		$this->addTestSuite('PaymentManagerTest');
//		$this->addTestSuite('LoanManagerTest');

		// Test the controllers and views.
		$this->addTestSuite('GenericControllerTest');
		$this->addTestSuite('PaymentControllerTest');
		$this->addTestSuite('LoanControllerTest');
	}
	
	/**
	 * Creates the suite.
	 */
	public static function suite() {
		return new self ( );
	}
}
// @codeCoverageIgnoreStop
