<?php

// 0. Initialize the Collabra Market library.
require '../Market.php';
Market::init();

if(!isset($_POST))
{
	exit;
}
	
session_start();

// 1. Grab the form data.
$targetLoanID  = filter_input(INPUT_POST, '', FILTER_SANITIZE_STRING);
$paymentID     = filter_input(INPUT_POST, '', FILTER_SANITIZE_STRING);
$amount        = filter_input(INPUT_POST, '', FILTER_SANITIZE_NUMBER_FLOAT);

echo '<pre>', print_r($_SESSION, true), '</pre>';

// 2. Pay the loan.
// todo

// 4. Redirect back to the main page.
// FIXME: Needs a proper dynamic URL generator.
//header('Location: http://www.phpu.cc/collabra/market/web/');

