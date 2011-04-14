<?php

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
	}

	protected function grabUserInput()
	{
		if(!isset($_POST))
		{
			throw new ControllerException("No user input", ControllerException::INVALID_USER_INPUT);
		}

		$commodityName = filter_input(INPUT_POST, 'loan_commodity',     FILTER_SANITIZE_STRING);
		$quantity      = filter_input(INPUT_POST, 'loan_quantity',      FILTER_SANITIZE_NUMBER_FLOAT);
		$loanTerm      = (int)filter_input(INPUT_POST, 'loan_term',     FILTER_SANITIZE_NUMBER_INT);
		$interestRate  = filter_input(INPUT_POST, 'loan_interest_rate', FILTER_SANITIZE_NUMBER_FLOAT);

		return array($commodityName, $quantity, $loanTerm, $interestRate);
	}
}

