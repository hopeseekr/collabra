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
$commodityName = filter_input(INPUT_POST, 'loan_commodity',     FILTER_SANITIZE_STRING);
$quantity      = filter_input(INPUT_POST, 'loan_quantity',      FILTER_SANITIZE_NUMBER_FLOAT);
$loanTerm      = filter_input(INPUT_POST, 'loan_term',          FILTER_SANITIZE_NUMBER_INT);
$interestRate  = filter_input(INPUT_POST, 'loan_interest_rate', FILTER_SANITIZE_NUMBER_FLOAT);

// 2. Build the commodity.
try
{
	$commodityStore = CommoditiesFactory::build($commodityName, $quantity);
}
catch(Exception $e)
{
	echo $e->getMessage();
	// TODO: Fill out exception handling
	exit;
}


// 3. Register the loan.
$_SESSION['loans'][] = array('commodityStore' => $commodityStore,
                             'loanTerm'       => $loanTerm,
                             'interestRate'   => $interestRate);

// 4. Redirect back to the main page.
// FIXME: Needs a proper dynamic URL generator.
header('Location: http://www.phpu.cc/collabra/market/web/');

