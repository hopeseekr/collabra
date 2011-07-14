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
	const FLAG_ALLOW_DEBT = 1;
	private static $instance;

	/** @return CommodityStore Returns the difference as Federal Reserve Notes.**/
	public function exchange(CommoditiesBasket $inputBasket, CommoditiesBasket $deliverableBasket, $flags = null)
	{
		// 1. Obtain the valuation difference for the two commodities.
		$difference = self::getValueDifferential($inputBasket, $deliverableBasket);

		// 2. Return the results from $this->handleValueDifference().
		return $this->handleValueDifference($difference, $flags);
	}

	// TODO: Rename to calculateValueDifferential()
	/** @return float The valuation difference between two commodities **/
	public static function getValueDifferential(CommoditiesBasket $inputBasket, CommoditiesBasket $deliverableBasket)
	{
		$difference = $inputBasket->getTotalValuation() - $deliverableBasket->getTotalValuation();

		return $difference;
	}
	
	/** @return CommodityStore Returns the difference as Federal Reserve Notes.**/
	protected function handleValueDifference($difference, $flags)
	{
		$frn = CommoditiesFactory::build("Federal Reserve Note");
		$frnStore = new CommodityStore($frn, $difference);
		if ($difference < 0)
		{
			if (!$flags & self::FLAG_ALLOW_DEBT)
			{
				throw new CommodityException("INSUFFICIENT FUNDS: Input is worth less than deliverable.");
			}
		}

		return $frnStore;
	}
}
