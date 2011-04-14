<?php

class LoanController
{
    public function registerLoan()
    {
        // 0. Initialize the Collabra Market library.
        require '../Market.php';
        Market::init();

    if(!isset($_POST))
    {
        exit;
    }

    session_start();

    // 1. Grab the form data.
    $commodityName = filter_input(INPUT_POST, 'loan_commodity',     FILTER_SANITIZE_STRING);
    $quantity      = filter_input(INPUT_POST, 'loan_quantity',      FILTER_SANITIZE_NUMBER_FLOAT);
    $loanTerm      = (int)filter_input(INPUT_POST, 'loan_term',     FILTER_SANITIZE_NUMBER_INT);
    $interestRate  = filter_input(INPUT_POST, 'loan_interest_rate', FILTER_SANITIZE_NUMBER_FLOAT);

    // 1.1. Sanity checks.
    if (!IS_STRING($commodityName)) { throw new InvalidArgumentException("Commodity name must be a string"); }
    if (!IS_NUMERIC($quantity)) { throw new InvalidArgumentException("Quantity must be a float"); }
    if (!IS_INT($loanTerm)) { throw new InvalidArgumentException("Loan term must be an integer"); }
    if (!IS_NUMERIC($interestRate)) { throw new InvalidArgumentException("Interest rate must be a float"); }

    if ($quantity <= 0) { throw new OutOfBoundsException("The loan commodity quantity must be more than 0."); }
    if ($loanTerm <= 0) { throw new OutOfBoundsException("The loan tern must be more than 0."); }
    if ($interestRate <= 0) { throw new OutOfBoundsException("The interest rate must be more than 0."); }

    // 2. Build the commodity.
    try
    {
        $commodityStore = CommoditiesFactory::build($commodityName, $quantity);
    }
    catch(Exception $e)
    {
        echo $e->getMessage();
        // TODO: Fill out exception handling
        exit;
    }


    // 3. Register the loan.
    $_SESSION['loans'][] = array('commodityStore' => $commodityStore,
                                 'loanTerm'       => $loanTerm,
                                 'interestRate'   => $interestRate);

    // 4. Redirect back to the main page.
    // FIXME: Needs a proper dynamic URL generator.
    header('Location: http://www.phpu.cc/collabra/market/web/');
}
}