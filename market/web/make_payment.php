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
$paymentID     = filter_input(INPUT_POST, 'payment_commodity', FILTER_SANITIZE_NUMBER_INT);
$targetLoanID  = filter_input(INPUT_POST, 'target_loan',       FILTER_SANITIZE_NUMBER_INT);
$amount        = filter_input(INPUT_POST, 'loan_quantity',     FILTER_SANITIZE_NUMBER_FLOAT);

// 1.1. Sanity checks.
if (!is_int($targetLoanID)) { throw new InvalidArgumentException("Target Loan ID must be an integer."); }
// Now use this template for the other two, honey.
if (!is_int($paymentID)) { throw new InvalidArgumentException("Payment ID must be an integer."); }
if (!is_numeric($amount)) { throw new InvalidArgumentException("Amount must be a float."); }

if (!isset($_SESSION['payments'])) { throw new RuntimeException("You must have a registered payment to make a payment."); }
if (!isset($_SESSION['loans'])) { throw new RuntimeException("You must have a registered loan to make a payment."); }

if (!isset($_SESSION['payments'][$paymentID])) { throw new InvalidArgumentException("Invalid Payment ID."); }
if (!isset($_SESSION['loans'][$targetLoanID])) { throw new InvalidArgumentException("Invalid Target Loan ID."); }

if ($amount <= 0) { throw new OutOfBoundsException("The payment commodity amount must be more than 0."); }

echo '<pre>', print_r($_SESSION, true), '</pre>';

// 2. Pay the loan.
// ok watch . I'm going to remove it then assist you (if needed) in recreating.
// So right now, we have a $_SESSION[] array filled with arrays of payments nad 
// loans.  The keys to the arrays are numbers starting at zero. OK? ok

$loan = $_SESSION[$targetLoanID];

// What happens if the $targetLoanID is blank or doesnt exist in the $_SESSION?
// You can't make a payment. Right but what will PHP do right now w/ the code we have?
// Return the error? Yeah it will say something like "Warning: $_SESSION[2] is not defined".
// But it wont stop the script, so that leads us (atm) open to attack at worse and an unknown
// state of execution at best. So how do we fix this? Exception against what? No input
// and? $targetLoanID not existing in $_SESSION! right. What do we call these checks? 
// sanity and where do they go? At the beginning right! ok I'm proud of you for remembering ;) 

// 4. Redirect back to the main page.
// FIXME: Needs a proper dynamic URL generator.
//header('Location: http://www.phpu.cc/collabra/market/web/');

