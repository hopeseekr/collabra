<?php

// Monica Chase (chase.mona@gmail.com) | 4 April 2011
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


