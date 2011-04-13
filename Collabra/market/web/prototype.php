<?php

// Monica Chase (monica@phpexperts.pro) | 4 April 2011
// Copyright (c) 2011 Theodore R. Smith <theodore@phpexperts.pro>
//
// Creating the new Commodity objects for Silver and the Federal Reserve Note
/*
require '../commodities/Commodity.class.php';
require '../storage/StorageSpecs.class.php';
require '../commodities/CommoditiesFactory.class.php';
*/

require '../Market.php';

Market::init();

$silver = CommoditiesFactory::build("Silver");
$frn    = CommoditiesFactory::build("Federal Reserve Note");

$theosBasket = new CommoditiesBasket();
$monicasBasket = new CommoditiesBasket();

// Adds 1 oz of precious silver.
$theosBasket->add($silver, 1);
// Adds 44 nearly-worthless FRNs.
$monicasBasket->add($frn, 44);

echo "Value of Theo's basket: $" . $theosBasket->getTotalValuation() . "\n";
printf("Value of Theo's basket: $%.2f\n", $theosBasket->getTotalValuation());
printf("Value of Monica's basket: $%.2f\n", $monicasBasket->getTotalValuation());

// Set up the Commodity Exchange.
$comex = CommodityExchange::getInstance();

// Get value differential between silver and FRNs.
$value = $comex->getValueDifferential($theosBasket, $monicasBasket);

echo "Differential: $value\n";
# The assert(<truth condition>) function does nothing if the condition inside
# of it is true, but exits the app if it;s false.
assert_options(ASSERT_BAIL, true);
assert($value == 1); 

