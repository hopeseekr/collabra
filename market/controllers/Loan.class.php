<?php

/** The Collabra Market Project
  *   Part of the Collabra Commercial Collaboration Platform
  *
  * Copyright(c) 2011 Theodore R. Smith <theodore@phpexperts.pro>
  * All rights reserved.
 **/

class LoanController implements CommandI
{
	public function execute($action)
	{
		if ($action == ActionsList::REGISTER_LOAN)
		{
			return $this->registerLoan();
		}
	}

	protected function registerLoan()
	{
		// 1. Grab the form data.
		list($commodityName, $quantity, $loanTerm, $interestRate) = $this->grabUserInput();

		// 2. Build the loan.
		$lender = new LoanManager;
		$loan = $lender->buildLoan($commodityName, $quantity, $loanTerm, $interestRate);

		// 3. Store the loan.
		$_SESSION['loans'][] = $loan;

		ControllerCommander::dispatch(ActionsList::SHOW_HOME);
	}

	protected function grabUserInput()
	{
		if (empty($_POST))
		{
			throw new ControllerException("No user input", ControllerException::INVALID_USER_INPUT);
		}

		$commodityName = fRequest::post('loan_commodity',     'string');
		$quantity      = fRequest::post('loan_quantity',      'float');
		$loanTerm      = fRequest::post('loan_term',          'integer');
		$interestRate  = fRequest::post('loan_interest_rate', 'float');

		return array($commodityName, $quantity, $loanTerm, $interestRate);
	}
}

