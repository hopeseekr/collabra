<?php
/** The Collabra Market Project
  *   Part of the Collabra Commercial Collaboration Platform
  *
  * Copyright(c) 2011 Theodore R. Smith <theodore@phpexperts.pro>
  * Copyright(c) 2011 Monica A. Chase <monica@phpexperts.pro>
  * All rights reserved.
 **/

require_once 'bootstrap.inc.php';
require_once 'PHPUnit/Framework/TestCase.php';

class LoanControllerTest extends PHPUnit_Framework_TestCase
{
	/** @var LoanController **/
	private $controller;
	/**
	 * Prepares the environment before running a test.
	 */
	protected function setUp()
	{
        $this->controller = new LoanController;
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

    public function testWillNotRegisterALoanWithoutUserInput()
    {
        try
        {
            $this->controller->execute(ActionsList::REGISTER_LOAN);
            $this->fail('Worked without any user input');
        }
        catch (ControllerException $e)
        {
            $this->assertEquals(ControllerException::INVALID_USER_INPUT, $e->getCode());
        }
    }
    
    public function testRequiresSaneInputs()
    {
        $_SERVER['REQUEST_METHOD'] = 'post';
        $goodData = array('loan_commodity' => 'Federal Reserve Note',
                       'loan_quantity'  => 8500.00,
                       'loan_term' => 15,
                       'loan_interest_rate' => 6.0);
        
        $testParams = array('loan_quantity', 'loan_term', 'loan_interest_rate');
        foreach ($testParams as $param)
        {
            $_POST = $goodData;
            $_POST[$param] = -5;

            try
            {
                $this->controller->execute(ActionsList::REGISTER_LOAN);
                $this->fail("Worked with invalid $param");
            }
            catch (OutOfBoundsException $e)
            {
            }
        }
    }
    
    public function testWillRegisterALoan()
    {
        $_SERVER['REQUEST_METHOD'] = 'post';
        $_POST = array('loan_commodity' => 'Federal Reserve Note',
                       'loan_quantity'  => 8500.00,
                       'loan_term' => 15,
                       'loan_interest_rate' => 6.0);

        $this->controller->execute(ActionsList::REGISTER_LOAN);
        file_put_contents('output.txt', serialize($_SESSION['loans']));
    }
}

















