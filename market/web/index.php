<?php

// Monica Chase (chase.mona@gmail.com) | 4 April 2011
//
// Creating the new Commodity objects for Silver and the Federal Reserve Note

require '../commodities/Commodity.class.php';
require '../storage/StorageSpecs.class.php';
require '../commodities/CommoditiesFactory.class.php';

$silver = CommoditiesFactory::build("Silver");
$frn    = CommoditiesFactory::build("Federal Reserve Note");
