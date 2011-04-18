<?php
/** The Collabra Market Project
  *   Part of the Collabra Commercial Collaboration Platform
  *
  * Copyright(c) 2011 Theodore R. Smith <theodore@phpexperts.pro>
  * Copyright(c) 2011 Monica A. Chase <monica@phpexperts.pro>
  * All rights reserved.
 **/

class PaymentManager
{
	/**
	  * @param string $commodityName
	  * @param float $quantity
	  * @return CommodityStore
	  */
    public function buildPaymentBasket($commodityName, $quantity)
	{
		// 1. Sanity checks.
		$this->ensureSaneInputs_BPB($commodityName, $quantity);

		// 2. Build the commodity.
		$commodityStore = CommoditiesFactory::build($commodityName, $quantity);

		return $commodityStore;
	}

	// FIXME: This is a great candidate for the Strategy Pattern.
	protected function ensureSaneInputs_BPB($commodityName, $quantity)
	{
		if (!is_string($commodityName)) { throw new InvalidArgumentException("Commodity Name must be a string"); }
		if (!is_numeric($quantity)) { throw new InvalidArgumentException("Quantity must be a float"); }

		if ($quantity <= 0) { throw new OutOfBoundsException("The payment commodity quantity must be more than 0."); }
	}

	/** handlePaymentTransaction() applies a payment to a debt and returns the change.
	  *
	  * @param CommodityBasket $paymentBasket
	  * @param CommodityBasket $loanBasket
	  * @param float $amount
	  * @return CommodityBasket The change differential between $paymentBasket and $loanBasket
	  */
	// FIXME: Shouldn't we standardize $amount as $quantity instead???
    public function handlePaymentTransaction($paymentBasket, $loanBasket, $amount)
	{
		// 1. Sanity checks.
		if ($amount <= 0) { throw new OutOfBoundsException("The payment commodity amount must be more than 0."); }

		// 2. Pay the loan.
		// loans.  The keys to the arrays are numbers starting at zero. OK? ok

		$comex = CommoditiesExchange::getInstance();

# A class' public functions should ONLY directly aid in accomplishing the goals of the class.
# A class' functions should NEVER be made public out of "coding convenience", as this is a sure
# sign of improper design and a breaking of Encapsulation.

		try
		{
			$FRNs = $comex->exchange($paymentBasket, $loanBasket);
		}
		catch(CommoditiesException $e)
		{
			// Since we expect the possibilty of the loan not being paid off in full,
			// we're just going to ignore this exception but re-throw any others.
			if ($e->getMessage() != "INSUFFICIENT FUNDS: Input is worth less than deliverable.")
			{
				throw $e;
			}
		}

		// 3. Update the loan amount.
		// TODO: This really needs to be stored in a database.
		$modifiedLoanBasket = CommoditiesFactory::build($loanBasket->commodity->name, $FRNs->quantity);

		return $modifiedLoanBasket;
	}
}
