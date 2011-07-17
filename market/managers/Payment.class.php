<?php

/** The Collabra Market Project
  *   Part of the Collabra Commercial Collaboration Platform
  *
  * Copyright(c) 2011 Theodore R. Smith <theodore@phpexperts.pro>
  * All rights reserved.
 **/

class PaymentManager
{
	/**
	  * @param string $commodityName
	  * @param float $quantity
	  * @return CommodityBasket
	  */
	public function buildPaymentBasket($commodityName, $quantity)
	{
		// 1. Sanity checks.
		$this->ensureSaneInputs_BPB($commodityName, $quantity);

		// 2. Build the commodity.
		$commodity = CommoditiesFactory::build($commodityName);

		// 3. Build the basket.
		$basket = new CommoditiesBasket;
		$basket->add($commodity, $quantity);

		return $basket;
	}

	// FIXME: This is a great candidate for the Strategy Pattern.
	protected function ensureSaneInputs_BPB($commodityName, $quantity)
	{
		if (empty($commodityName) || !is_string($commodityName)) { throw new InvalidArgumentException("Commodity Name must be a string"); }
		if (!is_numeric($quantity)) { throw new InvalidArgumentException("Quantity must be a float"); }

		if ($quantity <= 0) { throw new OutOfBoundsException("The payment commodity quantity must be more than 0."); }
	}

	// TODO: Refactor to remove $quantity.
	/** handlePaymentTransaction() applies a payment to a debt and returns the change.
	  *
	  * @param CommodityBasket $paymentBasket
	  * @param array $loan
	  * @param float $amount
	  * @return array A loan with the differential between $paymentBasket and $loan
	  */
	public function handlePaymentTransaction(CommoditiesBasket $paymentBasket, array $loan, $amount)
	{
		// 1. Sanity checks.
		if ($paymentBasket->getTotalValuation() <= 0) { throw new OutOfBoundsException("The payment commodity amount must be more than 0."); }

		// 2. Pay the loan.
		// loans.  The keys to the arrays are numbers starting at zero. OK? ok
		$comex = new CommoditiesExchange;

# A class' public functions should ONLY directly aid in accomplishing the goals of the class.
# A class' functions should NEVER be made public out of "coding convenience", as this is a sure
# sign of improper design and a breaking of Encapsulation.
		$loanBasket = $loan['basket'];
		$FRNs = $comex->exchange($paymentBasket, $loanBasket, CommoditiesExchange::FLAG_ALLOW_DEBT);
//printf("Payment value: %.2f\n", $paymentBasket->getTotalValuation());
//printf("Loan value: %.2f\n", $loanBasket->getTotalValuation());
//echo "FRNs owed by lender: " . $FRNs->calculateWorth() . "\n";

		// 3. Update the loan amount.
		// TODO: This really needs to be stored in a database.
		$loanStore = $loanBasket->take();
		$modifiedLoanCommodity = CommoditiesFactory::build($loanStore->commodity->name);
		$modifiedLoanBasket = new CommoditiesBasket;
		$modifiedLoanBasket->add($modifiedLoanCommodity, $FRNs->quantity * -1);
//printf("Modified loan value: %.2f\n", $modifiedLoanBasket->getTotalValuation());

		$lender = new LoanManager;
		$modifiedLoan = $lender->buildLoan($loanStore->commodity->name, $FRNs->quantity * -1, $loan['loanTerm'], $loan['interestRate']);

		return $modifiedLoan;
	}
}
