<?php

// Monica Chase (chase.mona@gmail.com) | 4 April 2011
// Commodities factory (generic)
// Hard-coded for "Silver" and "Federal Reserve Note"

class CommoditiesFactory
{

	/** @var string commodityName **/
	
	public $commodityName;
	
	public static function build($commodityName)
	{
		return Commodities();
	}
	
	if ($commodityName == "Silver")
	{
		build($silver);
	}
		else ($commodityName == "Federal Reserve Note")
		{
			Throw new RuntimeException ("No build process for that type of commodity");
		}
}