<?php

// Monica Chase (monica@phpexperts.pro) | 4 April 2011
// Copyright (c) 2011 Theodore R. Smith <theodore@phpexperts.pro>
// Commodities factory (generic)
// Hard-coded for "Silver" and "Federal Reserve Note"

class CommoditiesFactory
{
	public static function build($commodityName)
	{
		if ($commodityName == "Silver")
		{
			$silver = new CommoditiesBasket;
			$silver->name = "Silver";
			$silver->type = "precious metal";
			$silver->currentValuation = 45.00;
			$silver->averageValuation = 20.00;

			$silverSpecs = new StorageSpecs;
			$silverSpecs->isVirtual = false;
			$silverSpecs->weight = 31.1035;
			$silverSpecs->dimensions = array('width' => 5, 'height' => 5, 'depth' => 0.1);
			$silverSpecs->fragility = 30.00;
			$silverSpecs->toxicity = 0.00;
			$silverSpecs->expiresAfter = "0000-00-00 00:00:00";

			$silver->storageSpecs = $silverSpecs;

			return $silver;
		}
		else if ($commodityName == "Federal Reserve Note")
		{
			$frn = new CommoditiesBasket;
			$frn->name = "Federal Reserve Note";
			$frn->type = "fiat paper";
			$frn->currentValuation = 1.00;
			$frn->averageValuation = 1.00;

			$frnSpecs = new StorageSpecs;
			$frnspecs->isVirtual = true;
			$frnSpecs->weight = 1.0000;
			$frnSpecs->dimensions = array('width' => 15.5956, 'height' => 6.6294, 'depth' =>
			$frnSpecs->fragility = 70;
			$frnSpecs->toxicity = 5.00;
			$frnSpecs->expiresAfter = "0000-00-00 00:00:00";

			$frn->storageSpecs = $frnSpecs;

			return $frn;
		}
		else
		{
			throw new CommodityException("No build process for that type of commodity");
		}
}
