<?php

// Monica Chase (monica@phpexperts.pro) | 8 April 2011
// Copyright (c) 2011 Theodore R. Smith <theodore@phpexperts.pro> 



class Market
{
	private function __construct() { }
	public static function init()
	{
		if (defined('CMARKET_LIB_PATH'))
		{
			// It seems the library has already been initialized; bail.
			return;
		}

		define('CMARKET_LIB_PATH', dirname(__FILE__));

		include CMARKET_LIB_PATH . '/api/Command.interface.php';
		include CMARKET_LIB_PATH . '/api/View.interface.php';

		include CMARKET_LIB_PATH . '/models/Commodity.datatype.php';
		include CMARKET_LIB_PATH . '/models/CommodityStore.datatype.php';
		include CMARKET_LIB_PATH . '/commodities/CommoditiesBasket.class.php';
		include CMARKET_LIB_PATH . '/commodities/CommoditiesExchange.class.php';
		include CMARKET_LIB_PATH . '/commodities/CommoditiesFactory.class.php';

		include CMARKET_LIB_PATH . '/controllers/ControllerCommander.class.php';
		include CMARKET_LIB_PATH . '/controllers/Loan.class.php';
		include CMARKET_LIB_PATH . '/controllers/Payment.class.php';

	}
}

