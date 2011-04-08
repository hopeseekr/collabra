<?php

// Load require files...
require '../managers/Security.class.php';
require '../managers/User.class.php';
require '../managers/Authentication.class.php';



// Revision 1 (31 March 2011) | Monica Chase (monica@phpexperts.pro)
//
// Type "i" to get into insert mode...

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




// -- Monica's code
$bouncer = new SecurityManager();
$usher = new AuthenticationManager($bouncer);
