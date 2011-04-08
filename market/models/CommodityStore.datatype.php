<?php

// Monica Chase (chase.mona@gmail.com) | 5 April 2011
// Copyright (c) 2011 Theodore R. Smith <theodore@phpexperts.pro>

/*
The realization I made was that we really have commodity stores
and not just commodities. A store is defined as multiple of the same
commodity.*/

class CommodityStore
{
	/** @var Commodity **/
	public $commodity;
	public $quantity = 0;

	public function __construct(Commodity $commodity = null, $quantity = 1)
	{
		if ($commodity !== null)
		{
			$this->commodity = $commodity;
			$this->quantity = $quantity;
		}
	}

	public function calculateWorth()
	{
		if ($this->commodity === null) { return 0.00; }

		// The (float) bit is called Type casting. There's an article on it
		// in PHPU if interested.
		return (float)$this->commodity->currentValuation * (float)$quantity;
	}
}

