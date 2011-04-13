<?php

// Monica Chase (monica@phpexperts.pro) | 8 April 2011
// Copyright (c) 2011 Theodore R. Smith <theodore@phpexperts.pro> 



class Market
{
	private function __construct() { }
	public static function init()
	{
		define('CMARKET_LIB_PATH', dirname(__FILE__));

		include CARS_LIB_PATH . '/models/Commodity.datatype.php';
		include CARS_LIB_PATH . '/models/CommodityStore.datatype.php';
		include CARS_LIB_PATH . '/commodities/CommoditiesBasket.class.php';
		include CARS_LIB_PATH . '/commodities/CommoditiesExchange.class.php';
		include CARS_LIB_PATH . '/commodities/CommoditiesFactory.class.php';
			
	}
}

