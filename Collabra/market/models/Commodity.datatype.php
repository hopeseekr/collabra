<?php

// Monica Chase (monica@phpexperts.pro) | 4 April 2011
// Copyright (c) 2011 Theodore R. Smith <theodore@phpexperts.pro>

class Commodity
{
	public $name;
	public $type;
	public $currentValuation;
	public $averageValuation;
	public $storageSpecs;
}

// Create the custom commodity exception here, please.
class CommodityException extends RuntimeException
{
}


// Monica Chase (monica@phpexperts.pro) | 4 April 2011
// Copyright (c) 2011 Theodore R. Smith <theodore@phpexperts.pro>

class StorageSpecs
{
	/** @var bool A Virtual commodity can be effortlessly digitzed and transmitted electronically. **/
	public $isVirtual;
	
	/** @var float Weight is measured in grams (g). **/
	public $weight;

	/** @var float Dimensions is measured in centimeters (cm). **/
	public $dimensions;

	/** @var float Fragility is on a scale of 0-100; 100 == very, very fragile; 0 == diamonds **/
	public $fragility;

	/** @var float Toxicity is on a scale of 0-100; 100 == very, very toxic; 0 == completely harmless **/
	public $toxicity;

	/** @var string A datetime e.g. 2010-11-01 11:55:55 **/
	public $expiresAfter;
}
