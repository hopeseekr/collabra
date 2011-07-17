<?php

require_once realpath(dirname(__FILE__) . '/../Market.php');
Market::init();

function grabPageHTML($page)
{
	$filename = CMARKET_LIB_PATH . '/views/' . $page  . '.tpl.php';
	if (!file_exists($filename))
	{
		$this->assert(false, "Template file $page.tpl.php not found.");
	}

	ob_start();
	include $filename;
	$html = ob_get_clean();

	return $html;
}

// TODO: Migrate over to a CommoditiesFactory::buildBasket() factory.
function buildBasket($commodityName, $quantity)
{
	return buildPaymentBasket($commodityName, $quantity);
}

function buildPaymentBasket($commodityName, $quantity)
{
	$commodity = CommoditiesFactory::build($commodityName);
	$basket = new CommoditiesBasket();
	$basket->add($commodity, $quantity);

	return $basket;
}

