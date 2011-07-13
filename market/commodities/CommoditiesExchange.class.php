<?php

/** The Collabra Market Project
  *   Part of the Collabra Commercial Collaboration Platform
  *
  * Copyright(c) 2011 Theodore R. Smith <theodore@phpexperts.pro>
  * All rights reserved.
 **/

/** @package CollabraMarket **/
class CommoditiesExchange
{
	private static $instance;

	public function exchange(CommoditiesBasket $inputBasket, CommoditiesBasket $deliverableBasket)
	{
		// 1. Obtain the valuation difference for the two commodities.
		$difference = self::getValueDifferential($inputBasket, $deliverableBasket);

		// 2. Return the results from $this->handleValueDifference().
		return $this->handleValueDifference($difference);
	}

	/** @return float The valuation difference between two commodities **/
	public static function getValueDifferential(CommoditiesBasket $inputBasket, CommoditiesBasket $deliverableBasket)
	{
		$difference = $inputBasket->getTotalValuation() - $deliverableBasket->getTotalValuation();

		return $difference;
	}
	
	/** @return CommodityStore Returns the difference as Federal Reserve Notes.**/
	protected function handleValueDifference($difference)
	{
		$frn = CommoditiesFactory::build("Federal Reserve Note");
		$frnStore = new CommodityStore($frn, $difference);

		if ($difference < 0)
		{
			throw new CommodityException("INSUFFICIENT FUNDS: Input is worth less than deliverable.");
		}

		return $frnStore;
	}
}
