<?php

/** The Collabra Market Project
  *   Part of the Collabra Commercial Collaboration Platform
  *
  * Copyright(c) 2011 Theodore R. Smith <theodore@phpexperts.pro>
  * All rights reserved.
 **/

class LoanManager
{
	// TODO: Refactor LoanManager::buildLoan into a Factory.
	// TODO: Refactor to replace CommodityStore with CommoditiesBasket.
	// TODO: Refactor to remove $quantity.
	/**
	  * @return array[CommodityStore, float $quantity, int $loanTerm, float $interestRate]
	 **/
	public function buildLoan($commodityName, $quantity, $loanTerm, $interestRate)
	{
		// 1. Sanity checks.
		$this->ensureSaneInputs($commodityName, $quantity, $loanTerm, $interestRate);

		// 2. Build the loan.
		$commodity = CommoditiesFactory::build($commodityName);

		$commodityBasket = new CommoditiesBasket();
		$commodityBasket->add($commodity, $quantity);

		$loan = array('basket'       => $commodityBasket,
		              'loanTerm'     => $loanTerm,
		              'interestRate' => $interestRate);

		return $loan;
	}

	protected function ensureSaneInputs($commodityName, $quantity, $loanTerm, $interestRate)
	{
		if (empty($commodityName) || !is_string($commodityName)) { throw new InvalidArgumentException("Commodity name must be a string"); }
		if (empty($quantity) || !is_numeric($quantity)) { throw new InvalidArgumentException("Quantity must be a float"); }
		if (empty($loanTerm) || !is_int($loanTerm)) { throw new InvalidArgumentException("Loan term must be an integer"); }
		if (empty($interestRate) || !is_numeric($interestRate)) { throw new InvalidArgumentException("Interest rate must be a float"); }

		if ($quantity <= 0) { throw new OutOfBoundsException("The loan commodity quantity must be more than 0."); }
		if ($loanTerm <= 0) { throw new OutOfBoundsException("The loan tern must be more than 0."); }
		if ($interestRate <= 0) { throw new OutOfBoundsException("The interest rate must be more than 0."); }
	}
}
