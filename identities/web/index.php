<?php

// Load require files...
require '../managers/Security.class.php';
require '../managers/User.class.php';
require '../managers/Authentication.class.php';



// Revision 1 (31 March 2011) | Monica Chase (chase.mona@gmail.com)
//
// Type "i" to get into insert mode...

$bouncer = new SecurityManager();
$usher = new AuthenticationManager($bouncer);
$personalAssistant = new UserManager();

// Login the user...
//$personalAssistant->login("test", "test");
$personalAssistant->login("test", "test");

$bouncer->


// -- Monica's code
$bouncer = new SecurityManager();
$usher = new AuthenticationManager($bouncer);
