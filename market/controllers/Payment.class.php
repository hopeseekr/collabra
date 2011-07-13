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
    /** @var PaymentManager **/
    private $bookie;

    public function __construct(PaymentManager $bookie = null)
    {
        $this->bookie = ($bookie !== null) ? $bookie : new PaymentManager;
    }

	public function execute($action)
	{
		// These actions dont actually return any HTML. They should,
		// instead redirect back to the home page. -Theo 2011-04-19
		if ($action == ActionsList::CREATE_PAYMENT_BASKET)
		{
			$this->createPaymentBasket();
		}
		else if ($action == ActionsList::MAKE_PAYMENT)
		{
			$this->makePayment();
		}
	}

    protected function createPaymentBasket()
	{
		// 1. Grab the form data.
        // FIXME: This is a great candidate for the Strategy Pattern.
        if(empty($_POST))
        {
            throw new ControllerException("No user input", ControllerException::INVALID_USER_INPUT);
        }

		$commodityName = fRequest::post('payment_commodity', 'string');
		$quantity = fRequest::post('payment_quantity', 'float');

		// 2. Build the payment basket.
		$paymentBasket = $this->bookie->buildPaymentBasket($commodityName, $quantity);

		// 3. Register the payment basket in the session.
		$_SESSION['payments'][] = $paymentBasket;

        ControllerCommander::dispatch(ActionsList::SHOW_HOME);
	}

    protected function makePayment()
	{
		// 1. Grab the form data.
		// FIXME: This is a great candidate for the Strategy Pattern.
		$paymentID     = fRequest::post('payment_commodity', 'integer');
		$loanID        = fRequest::post('target_loan',       'integer');
		$amount        = fRequest::post('loan_quantity',     'float');
        error_log("Ammount: " . $amount);

		// Sanity checks.
		$this->ensureSaneInputs_MP($paymentID, $loanID, $amount);


		// TODO: Remove debug info.
		//echo 'BEforE: <pre>', print_r($_SESSION, true), '</pre>';

		// 2. Retrieve our baskets.
		$paymentBasket = $_SESSION['payments'][$paymentID];
		$loanBasket = $_SESSION['loans'][$loanID];

		// 2. Pay the loan.
		$modifiedLoanBasket = $this->bookie->handlePaymentTransaction($paymentBasket, $loanBasket, $amount);

		// 3. Record the transaction and update the ledgers.
		$this->recordTransaction($paymentID, $loanID, $modifiedLoanBasket);

		// TODO: Remove debug info.
		//echo 'AFTER: <pre>', print_r($_SESSION, true), '</pre>';

        ControllerCommander::dispatch(ActionsList::SHOW_HOME);
	}

	// TODO: Great candidate for Strategy Pattern.
	protected function ensureSaneInputs_MP($paymentID, $loanID, $amount)
	{
        if (empty($_POST))
        {
            throw new ControllerException("No user input", ControllerException::INVALID_USER_INPUT);
        }

        if (!is_int($loanID)) { throw new InvalidArgumentException("Target Loan ID must be an integer."); }
        // Now use this template for the other two, honey.
        if (!is_int($paymentID)) { throw new InvalidArgumentException("Payment ID must be an integer."); }
        if (!is_numeric($amount)) { throw new InvalidArgumentException("Amount must be a float."); }

        if (!isset($_SESSION['payments'])) { throw new LogicException("You must have a registered payment to make a payment."); }
        if (!isset($_SESSION['loans'])) { throw new LogicException("You must have a registered loan to make a payment."); }

        if (!isset($_SESSION['payments'][$paymentID])) { throw new InvalidArgumentException("Invalid Payment ID."); }
        if (!isset($_SESSION['loans'][$loanID])) { throw new InvalidArgumentException("Invalid Target Loan ID."); }
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
