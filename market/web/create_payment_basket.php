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

// 1.1. Sanity checks.
if (!IS_STRING($commodityName)) { throw new InvalidArgumentException("Commodity Name must be a string"); }
if (!IS_NUMERIC($quantity)) { throw new InvalidArgumentException("Quantity must be a float"); }

if ($quantity <= 0) { throw new OutOfBoundsException("The payment commodity quantity must be more than 0."); }

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
