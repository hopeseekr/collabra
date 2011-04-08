<?php

// Monica Chase (monica@phpexperts.pro) | 4 April 2011
// Copyright (c) 2011 Theodore R. Smith <theodore@phpexperts.pro>
//
// Creating the new Commodity objects for Silver and the Federal Reserve Note

require '../commodities/Commodity.class.php';
require '../storage/StorageSpecs.class.php';
require '../commodities/CommoditiesFactory.class.php';

$silver = CommoditiesFactory::build("Silver");
$frn    = CommoditiesFactory::build("Federal Reserve Note");
