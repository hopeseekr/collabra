<?php

/** The Collabra Market Project
  *   Part of the Collabra Commercial Collaboration Platform
  *
  * Copyright(c) 2011 Theodore R. Smith <theodore@phpexperts.pro>
  * All rights reserved.
 **/
 
/*
require '../commodities/Commodity.class.php';
require '../storage/StorageSpecs.class.php';
require '../commodities/CommoditiesFactory.class.php';
*/

require_once realpath(dirname(__FILE__) . '/../Market.php');
Market::init();

$silver = CommoditiesFactory::build("Silver");
$frn    = CommoditiesFactory::build("Federal Reserve Note");

$silverBasket = new CommodityBasket();
$frnBasket = new CommodityBasket();

// Adds 1 oz of precious silver.
$silverBasket->add($silver, 1);
// Adds 44 nearly-worthless FRNs.
$frnBasket->add($frn, 44);

echo "Value of Silver basket: $" . $silverBasket->getTotalValuation() . "\n";
printf("Value of Silver basket: $%.2f\n", $silverBasket->getTotalValuation());
printf("Value of FRN basket: $%.2f\n", $frnBasket->getTotalValuation());

// Set up the Commodity Exchange.
$comex = CommoditiesExchange::getInstance();

// Get value differential between silver and FRNs.
$value = $comex->calculateValueDifferential($silverBasket, $frnBasket);

echo "Differential: $value\n";
# The assert(<truth condition>) function does nothing if the condition inside
# of it is true, but exits the app if it;s false.
assert_options(ASSERT_BAIL, true);
assert($value == 1); 

