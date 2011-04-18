<?php
/** The Collabra Market Project
  *   Part of the Collabra Commercial Collaboration Platform
  *
  * Copyright(c) 2011 Theodore R. Smith <theodore@phpexperts.pro>
  * Copyright(c) 2011 Monica A. Chase <monica@phpexperts.pro>
  * All rights reserved.
 **/

class PaymentController implements CommandI
{
	public function execute($action)
	{
		if ($action == ActionsList::CREATE_PAYMENT_BASKET)
		{
			return $this->createPaymentBasket();
		}
		else if ($action == ActionList::MAKE_PAYMENT)
		{
			return $this->makePayment();
		}
	}

    public function createPaymentBasket()
	{
		// 1. Grab the form data.
		// FIXME: This is a great candidate for the Strategy Pattern.
		if(!isset($_POST))
		{
			throw new ControllerException("No user input", ControllerException::INVALID_USER_INPUT);
		}

		$commodityName = filter_input(INPUT_POST, 'payment_commodity', FILTER_SANITIZE_STRING);
		$quantity = filter_input(INPUT_POST, 'payment_quantity', FILTER_SANITIZE_NUMBER_FLOAT);

		// 2. Build the payment basket.
		$bookie = new PaymentManager;
		$paymentBasket = $bookie->buildPaymentBasket($commodityName, $quantity);

		// 3. Register the payment basket in the session.
		$_SESSION['payments'][] = $paymentBasket;
	}

    public function makePayment()
	{
		// 1. Grab the form data.
		// FIXME: This is a great candidate for the Strategy Pattern.
		$paymentID     = (int)filter_input(INPUT_POST, 'payment_commodity', FILTER_SANITIZE_NUMBER_INT);
		$loanID        = (int)filter_input(INPUT_POST, 'target_loan',       FILTER_SANITIZE_NUMBER_INT);
		$amount        = filter_input(INPUT_POST, 'loan_quantity',          FILTER_SANITIZE_NUMBER_FLOAT);

		// Sanity checks.
		$this->ensureSaneInputs_MP($paymentID, $loanID, $amount);


		// TODO: Remove debug info.
		echo 'BEforE: <pre>', print_r($_SESSION, true), '</pre>';

		// 2. Retrieve our baskets.
		$paymentBasket = $_SESSION['payments'][$paymentID];
		$loanBasket = clone $_SESSION['loans'][$targetLoanID];

		// 2. Pay the loan.
		$bookie = new PaymentManager;
		$modifiedLoanBasket = $bookie->handlePaymentTransaction($paymentBasket, $loanBasket, $amount);
	
		// 3. Record the transaction and update the ledgers.
		$this->recordTransaction($paymentID, $loanID, $modifiedLoanBasket);

		// TODO: Remove debug info.
		echo 'AFTER: <pre>', print_r($_SESSION, true), '</pre>';
	}

	// TODO: Great candidate for Strategy Pattern.
	protected function ensureSaneInputs_MP($paymentID, $loanID, $amount)
	{
        if (!isset($_POST))
        {
            throw new ControllerException("No user input", ControllerException::INVALID_USER_INPUT);
        }

        if (!is_int($targetLoanID)) { throw new InvalidArgumentException("Target Loan ID must be an integer."); }
        // Now use this template for the other two, honey.
        if (!is_int($paymentID)) { throw new InvalidArgumentException("Payment ID must be an integer."); }
        if (!is_numeric($amount)) { throw new InvalidArgumentException("Amount must be a float."); }

        if (!isset($_SESSION['payments'])) { throw new RuntimeException("You must have a registered payment to make a payment."); }
        if (!isset($_SESSION['loans'])) { throw new RuntimeException("You must have a registered loan to make a payment."); }

        if (!isset($_SESSION['payments'][$paymentID])) { throw new InvalidArgumentException("Invalid Payment ID."); }
        if (!isset($_SESSION['loans'][$targetLoanID])) { throw new InvalidArgumentException("Invalid Target Loan ID."); }
	}

	protected function recordTransaction($paymentID, $loanID, $modifiedLoanBasket)
	{
		// Prevent a memory leak by unsetting the old loan object.
		unset($_SESSION['loans'][$loanID]);

		// Store the new loan object in the session.
		$_SESSION['loans'][$loanID] = $modifiedLoanBasket;

		// Zero-out the payment.
		unset($_SESSION['payments'][$paymentID]);
	}
}
