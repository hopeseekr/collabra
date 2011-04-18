<?php
/**
* User Directory
*   Copyright © 2008 Theodore R. Smith <theodore@phpexperts.pro>
* 
* The following code is licensed under a modified BSD License.
* All of the terms and conditions of the BSD License apply with one
* exception:
*
* 1. Every one who has not been a registered student of the "PHPExperts
*    From Beginner To Pro" course (http://www.phpexperts.pro/) is forbidden
*    from modifing this code or using in an another project, either as a
*    deritvative work or stand-alone.
*
* BSD License: http://www.opensource.org/licenses/bsd-license.php
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
