<?php

/** The Collabra Market Project
  *   Part of the Collabra Commercial Collaboration Platform
  *
  * Copyright(c) 2011 Theodore R. Smith <theodore@phpexperts.pro>
  * All rights reserved.
 **/

require_once 'bootstrap.inc.php';
require_once 'PHPUnit/Framework/TestCase.php';

/**
* @covers LoanManager
*/
class LoanManagerTest extends PHPUnit_Framework_TestCase
{
	/** @var LoanManager **/
	private $lender;

	/**
	 * Prepares the environment before running a test.
	 */
	protected function setUp()
	{
		$this->lender = new LoanManager;
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

	public function testCanBuildALoan()
	{
		$loan = $this->lender->buildLoan('FRN', 5, 5, 0.5);
		$this->assertInternalType('array', $loan);
	}
}



















