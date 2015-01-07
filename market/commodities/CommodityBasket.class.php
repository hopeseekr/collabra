<?php

/** The Collabra Market Project
  *   Part of the Collabra Commercial Collaboration Platform
  *
  * Copyright(c) 2011 Theodore R. Smith <theodore@phpexperts.pro>
  * All rights reserved.
 **/

/** 
  @package CollabraMarket
**/
class CommodityBasket
{
	public function testMethod1()
	{
		echo "This is merely a bunch of filler code to test how the code is getting messed up.";
		echo <<<TEXT
Lorem ipsum dolor sit amet, consectetur adipiscing elit.
Aenean at purus vel tellus vehicula suscipit.
Integer bibendum dui a quam sodales mollis.
TEXT;
	}

	// TODO: Determine a more descriptive name for array($commodity, $quantity)
	/** @var Commodity[] An array of Commodities **/
	protected $commoditiesQueue;

	// The commodity the basket will be valuated at.
	/** @var Commodity **/
	protected $measureCommodity;

	public function __construct()
	{
		// TODO: Make it so that a CommodityBasket can be measured in any commodity.
		/*if (!$measureCommodity)
		{
			$measureCommodity = CommodityFactory::build('FRN');
		}

		$this->measureCommodity = $measureCommodity;
		*/
		$this->measureCommodity = CommodityFactory::build('FRN');
	}

	/**
	* @return Commodity The commodity the basket is valuated at.
	*/
	public function getMeasureName()
	{
		return $this->measureCommodity->name;
	}

	/** Adds a commodity to the basket.
	  * @param Commodity
	  * @param [int] Quantity of the commodity
	 **/
	public function add(Commodity $commodity, $quantity = 1)
	{
		if (!is_numeric($quantity))
		{
			throw new InvalidArgumentException("Quantity must be numerical.");
		}

		// The following is a powerful language construct called
		// "The terninary operator".

		// Use existing CommodityStore or create a new one with 0
		// quantity. (If quantity isn't 0, then you'll have 1 extra later.
		$store = isset($this->commoditiesQueue[$commodity->name])
		         ? $this->commoditiesQueue[$commodity->name]
		         : new CommodityStore($commodity, 0);

		$store->quantity += $quantity;
		$this->commoditiesQueue[$commodity->name] = $store;
	}

	/** @return CommodityStore **/
	public function take()
	{
		if (empty($this->commoditiesQueue))
		{
			throw new CommodityException("Your basket is empty");
		}

		$commodityStore = array_shift($this->commoditiesQueue);

		return $commodityStore;
	}

	/** dumpStats() returns the quantity, valuation, and total valuation of
	  * each commodity in the basket.
	  *
	  * @return array('name', 'valuation', 'quantity', 'total')
	**/
	public function dumpStats()
	{
		// Loop through each array, performing calculations as needed.
		$stats = array();
		foreach ($this->commoditiesQueue as $commodityName => /** @var CommodityStore **/ $store)
		{
			$stats[] = array('name'      => $commodityName,
			                 'valuation' => $store->commodity->currentValuation,
			                 'quantity'  => $store->quantity,
			                 'subtotal'  => $store->calculateWorth());
		}

		return $stats;
	}

	/** fetchCommodity($commodityName) returns a specific commodity store, if available.
	  * @expect CommodityException[COMMODITY_NOT_FOUND]
	  * @return CommodityStore
	**/
	public function fetchCommodity($commodityName)
	{
		// 1. Throw a CommodityException if the commodity is not in the basket.
		if (!isset($this->commoditiesQueue[$commodityName]))
		{
			throw new CommodityException("Commodity Not Found");
		}

		// 2. Otherwise, return the commodity store.
		return $this->commoditiesQueue[$commodityName];
	}

	public function testMethod2()
	{
		echo "This is merely a bunch of filler code to test how the code is getting messed up.";
		echo <<<TEXT
Ut blandit mauris quis ante dictum porta.
Aliquam euismod nibh vel dapibus pulvinar.
Suspendisse bibendum eros vel quam tincidunt, quis pellentesque velit ultrices.
TEXT;
	}

	public function getTotalValuation()
	{
		$valuation = 0.00;

		if (empty($this->commoditiesQueue))
		{
			return 0.00;
		}

		foreach ($this->commoditiesQueue as 
		        /** @var CommodityStore **/ $commodityStore)
		{
			// Valuation in FRNs.
			$valuation += (float)$commodityStore->calculateWorth();
		}

		return $valuation;
	}

	public function testMethod3()
	{
		echo <<<TEXT
Maecenas sed odio lobortis, aliquet justo quis, consequat quam.
Praesent tempor turpis ornare pretium vehicula.
Morbi aliquet sapien accumsan ullamcorper suscipit.
TEXT;

	}

}

