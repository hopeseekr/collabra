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

$APP_PATH = realpath(dirname(__FILE__) . '/..'); 


require_once 'PHPUnit/Framework/TestCase.php';

include $APP_PATH . '/managers/Security.class.php';
include $APP_PATH . '/models/User.data.php';

/**
 * SecurityController test case.
 */
class SecurityManagerTest extends PHPUnit_Framework_TestCase
{
	/** @var SecurityManager **/
	private $actor;
	/**
	 * Prepares the environment before running a test.
	 */
	protected function setUp()
	{
		$this->actor = new SecurityManager;
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

	public function testWillBlockAccessToUsersWithoutPermission()
	{
		// Fake user:
		$fakeUser = new User;
		$fakeUser->username = "invalid";
		$fakeUser->password = "Very frickin unlikely pass";

		$validURL = 'http://www.phpexperts.pro/';

		// 1. Test while not being logged in
		try
		{
			$this->actor->guardEntrance($fakeUser, $validURL);
			$this->assertTrue(false, 'worked without access.');
		}
		catch(Exception $e)
		{
			$this->assertEquals("You are not authorized.", $e->getMessage(), 'Didn\'t expect exception "' . $e->getMessage() . '".');
		}
	}
	
	public function testWillReportInvalidUrls()
	{
		$validUser = new User;
		$validUser->username = "test";
		$validUser->password = "test";

		$invalidURL = 'Imma Gunna Hack U, Boy!';

		// 1. Test while not being logged in
		try
		{
			$this->actor->guardEntrance($validUser, $invalidURL);
			$this->assertTrue(false, 'worked with invalid URL. probably hacked now ;/.');
		}
		catch(Exception $e)
		{
			$this->assertEquals("Invalid URL.", $e->getMessage(), 'Didn\'t expect exception "' . $e->getMessage() . '".');
		}
	}
	
	public function testWillBlockAccessToUnauthorizedUrls()
	{
		$validUser = new User;
		$validUser->username = "test";
		$validUser->password = "test";

		$unauthorizedURL = 'http://www.example.com/NotAuthorized/';

		// 1. Test while not being logged in
		try
		{
			$this->actor->guardEntrance($validUser, $unauthorizedURL);
			$this->assertTrue(false, 'worked with an unauthorized URL. Data exposure PR nightmare imminent. ;/.');
		}
		catch(Exception $e)
		{
			$this->assertEquals("Not Authorized.", $e->getMessage(), 'Didn\'t expect exception "' . $e->getMessage() . '".');
		}
	}
	
	public function testWillPermitAccessToAuthorizedUrls()
	{
		$validUser = new User;
		$validUser->username = "test";
		$validUser->password = "test";

		$authorizedURL = 'http://www.example.com/Authorized/';

		// 1. Test while not being logged in
		$this->actor->guardEntrance($validUser, $authorizedURL);
		$this->assertTrue(true, 'worked with an authorized URL..');
	}
	
}

