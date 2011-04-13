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
$commodityName = filter_input(INPUT_POST, 'payment_commodity', FILTER_SANITIZE_STRING);
$quantity = filter_input(INPUT_POST, 'payment_quantity', FILTER_SANITIZE_NUMBER_FLOAT);

// 2. Build the commodity.
try
{
	$commodityStore = CommoditiesFactory::build($commodityName, $quantity);
}
catch(Exception $e)
{
	printf('<h2 class="error">Error: Something weird happened: %s</h2>',
	       $e->getMessage());
	// Bail.
	exit;
}

// 3. Store the commodity store in the session.
$_SESSION['payments'][] = $commodityStore;

// 4. Redirect back to the main page.
// FIXME: Needs a proper dynamic URL generator.
header('Location: http://www.phpu.cc/collabra/market/web/');
