<?php
/** The Collabra Market Project
  *   Part of the Collabra Commercial Collaboration Platform
  *
  * Copyright(c) 2011 Theodore R. Smith <theodore@phpexperts.pro>
  * Copyright(c) 2011 Monica A. Chase <monica@phpexperts.pro>
  * All rights reserved.
 **/

class LoanManager
{
	/**
	  * @return array[CommodityStore, float $quantity, int $loanTerm, float $interestRate]
	 **/
	public function buildLoan($commodityName, $quantity, $loanTerm, $interestRate)
	{
		// 1. Sanity checks.
        error_log('m');
		$this->ensureSaneInputs($commodityName, $quantity, $loanTerm, $interestRate);

		// 2. Build the loan.
		$commodityStore = CommoditiesFactory::build($commodityName, $quantity);

		$loan = array('commodityStore' => $commodityStore,
		              'loanTerm'       => $loanTerm,
		              'interestRate'   => $interestRate);

		return $loan;
	}

	protected function ensureSaneInputs($commodityName, $quantity, $loanTerm, $interestRate)
	{
        error_log("Commodity name: " . $commodityName);
		if (empty($commodityName) || !is_string($commodityName)) { throw new InvalidArgumentException("Commodity name must be a string"); }
		if (empty($quantity) || !is_numeric($quantity)) { throw new InvalidArgumentException("Quantity must be a float"); }
		if (empty($loanTerm) || !is_int($loanTerm)) { throw new InvalidArgumentException("Loan term must be an integer"); }
		if (empty($interestRate) || !is_numeric($interestRate)) { throw new InvalidArgumentException("Interest rate must be a float"); }

		if ($quantity <= 0) { throw new OutOfBoundsException("The loan commodity quantity must be more than 0."); }
		if ($loanTerm <= 0) { throw new OutOfBoundsException("The loan tern must be more than 0."); }
		if ($interestRate <= 0) { throw new OutOfBoundsException("The interest rate must be more than 0."); }
	}

}
