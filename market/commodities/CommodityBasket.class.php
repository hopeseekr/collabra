<?php

// Monica Chase (chase.mona@gmail.com) | 5 April 2011
// Copyright (c) 2011 Theodore R. Smith <theodore@phpexperts.pro>

class CommodityBasket
{
	// TODO: Determine a more descriptive name for array($commodity, $quantity)
	/** @var Commodity[] An array of Commodities **/
	private $commoditiesQueue;

	/** Adds a commodity to the basket.
	  * @param Commodity
	  * @param [int] Quantity of the commodity
	 **/
	public function add(Commodity $commodity, $quantity = 1)
	{
		// Do you know how to add something to an array? no
		// It's pretty simple. $commodity[$key] = $newValue;
		// Or, if you don't care about what the key is and are cool
		// with it going from 0 on up, just do
		// $commodity[] = $newValue; OK? ok, but do we care about the key?
		// It's a good question, why would we? well I guess we don't, since we
		// only have one 'category' right?
		// I actually struggle with what to do. On one hand...
		// we're only going to ever have 1 commodityName per basket. If there
		// are two FRNs, we will have 1 FRN Commodity and state that its
		// quantity is 2, somewhere else (probably in the array).
		// So we could make the key name equal to $commodityName.
		// or we could do $commoditiesQueue[] = array($commodityName, $commodity,
		// $quantity) instead of array($commodity, $quantity).
		// 
		// What's your call? is one way better than the other?
	    // Unquestionably, one way will end up being better. But i have no
		// real opinion as of now which one it will be ;/ I'm favoring
		// the [] vs [$commodityName], gut call.
		//
		// If we end up having to  modify it later, how difficult 
		// will that be? HAHA If we did "mainstream encapsulation", very.
		// For us? Not hard.
		// Okay, then we'll do it your way.

		// Add a commodity + stats to $this->commoditiesQueue[]
		// array($commodityName, $quantity, $commodity)

		// Add to existing commodity if it exists.
		if (isset($this->commoditiesQueue[$commodity->name]))
		{
			$this->commoditiesQueue[$commodity->name]['quantity'] += $commodity->quantity;
		}

		$this->commoditiesQueue[$commodity->name] = array($commodity, 
		                                                  $quantity);
	}
	
	public function take()
	{
		if(empty($this->commoditiesQueue))
		{
			throw new CommodityException("Your basket is empty");
		}

		$commodity = array_shift($this->commoditiesQueue);

		return $commodity;
	}

	/** dumpStats() returns the quantity, valuation, and total valuation of
	  * each commodity in the basket. 
	  *    array('name', 'valuation', 'quantity', 'total')

	  * @return array
	**/
	public function dumpStats()
	{
		// 1. Loop through each array, performing calculations as needed.
		foreach ($this->commoditiesQueue as $item)
		{
		}
	}
}
