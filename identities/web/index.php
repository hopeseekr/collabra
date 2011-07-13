<?php
/** The Collabra Identities Project
  *   Part of the Collabra Commercial Collaboration Platform
  *
  * Copyright(c) 2011 Theodore R. Smith <theodore@phpexperts.pro>
  * All rights reserved.
 **/


// Load require files...
require '../managers/Security.class.php';
require '../managers/User.class.php';
require '../managers/Authentication.class.php';



define('EXAMPLE_URL', "http://www.phpexperts.pro/");

$bouncer = new SecurityManager();
$usher = new AuthenticationManager($bouncer);
$personalAssistant = new UserManager();

// Login the user...
//$personalAssistant->login("test", "test");
try
{
	$user = $personalAssistant->login("test", "test");
}
catch (Exception $e)
{
	echo "O no. The Personal Assistant refuses to serve you:\n\t" . $e->getMessage() . "\n";
}

try
{
	$usher->authenticateUser($user);
}
catch(Exception $e)
{
	echo "O no. The usher doesn't think you're who you say you are:\n\t" . $e->getMessage() . "\n";
}

try
{
	$bouncer->guardEntrance($user, EXAMPLE_URL);
}
catch (Exception $e)
{
	echo "O no. The bouncer has rejected your access:\n\t" . $e->getMessage() . "\n";
}


$bouncer = new SecurityManager();
$usher = new AuthenticationManager($bouncer);
