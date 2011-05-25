<?php
/** The Collabra Market Project
  *   Part of the Collabra Commercial Collaboration Platform
  *
  * Copyright(c) 2011 Theodore R. Smith <theodore@phpexperts.pro>
  * Copyright(c) 2011 Monica A. Chase <monica@phpexperts.pro>
  * All rights reserved.
 **/

require_once 'bootstrap.inc.php';
require_once 'PHPUnit/Extensions/OutputTestCase.php';

class GenericControllerTest extends PHPUnit_Extensions_OutputTestCase
{
	/** @var CommodityStore **/
	private $controller;
	/**
	 * Prepares the environment before running a test.
	 */
	protected function setUp()
	{
		$this->controller = new GenericController;

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

	public function testWillShow404PageForUnknownPages()
	{
		$errorPageHTML = $this->grabPageHTML('404');
		$this->expectOutputString($errorPageHTML);
	
		$this->controller->execute("UNKNOWN ACTION");
	}

	public function testWillShowHomePage()
	{
		$homePageHTML = $this->grabPageHTML('home');
		$this->expectOutputString($homePageHTML);

		$this->controller->execute(ActionsList::SHOW_HOME);
	}

    public function testWillShowMonicasBoobsToTheo()
	{
		// This goes to false if it doesn't actually happen ;p
		$this->assertTrue(true);
	}

	public function testWillShow404PageOnDemand()
	{
		$errorPageHTML = $this->grabPageHTML('404');
		$this->expectOutputString($errorPageHTML);
	
		$this->controller->execute(ActionsList::SHOW_404);
	}
}

