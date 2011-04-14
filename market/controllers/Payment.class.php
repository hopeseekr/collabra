<?php

class PaymentController
{

    public function createPaymentBasket()
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
    $commodityName = filter_input(INPUT_POST, 'payment_commodity', FILTER_SANITIZE_STRING);
    $quantity = filter_input(INPUT_POST, 'payment_quantity', FILTER_SANITIZE_NUMBER_FLOAT);

    // 1.1. Sanity checks.
    if (!IS_STRING($commodityName)) { throw new InvalidArgumentException("Commodity Name must be a string"); }
    if (!IS_NUMERIC($quantity)) { throw new InvalidArgumentException("Quantity must be a float"); }

    if ($quantity <= 0) { throw new OutOfBoundsException("The payment commodity quantity must be more than 0."); }

    // 2. Build the commodity.
    try
    {
        $commodityStore = CommoditiesFactory::build($commodityName, $quantity);
    }
    catch(Exception $e)
    {
        printf('<h2 class="error">Error: Something weird happened: %s</h2>',
               $e->getMessage());
        // Bail.
        exit;
    }

    // 3. Store the commodity store in the session.
    $_SESSION['payments'][] = $commodityStore;

    // 4. Redirect back to the main page.
    // FIXME: Needs a proper dynamic URL generator.
    header('Location: http://www.phpu.cc/collabra/market/web/');
    }

    public function makePayment()
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
    $paymentID     = (int)filter_input(INPUT_POST, 'payment_commodity', FILTER_SANITIZE_NUMBER_INT);
    $targetLoanID  = (int)filter_input(INPUT_POST, 'target_loan',       FILTER_SANITIZE_NUMBER_INT);
    $amount        = filter_input(INPUT_POST, 'loan_quantity',          FILTER_SANITIZE_NUMBER_FLOAT);

    // 1.1. Sanity checks.
    if (!is_int($targetLoanID)) { throw new InvalidArgumentException("Target Loan ID must be an integer."); }
    // Now use this template for the other two, honey.
    if (!is_int($paymentID)) { throw new InvalidArgumentException("Payment ID must be an integer."); }
    if (!is_numeric($amount)) { throw new InvalidArgumentException("Amount must be a float."); }

    if (!isset($_SESSION['payments'])) { throw new RuntimeException("You must have a registered payment to make a payment."); }
    if (!isset($_SESSION['loans'])) { throw new RuntimeException("You must have a registered loan to make a payment."); }

    if (!isset($_SESSION['payments'][$paymentID])) { throw new InvalidArgumentException("Invalid Payment ID."); }
    if (!isset($_SESSION['loans'][$targetLoanID])) { throw new InvalidArgumentException("Invalid Target Loan ID."); }

    if ($amount <= 0) { throw new OutOfBoundsException("The payment commodity amount must be more than 0."); }

    echo 'BEforE: <pre>', print_r($_SESSION, true), '</pre>';

    // 2. Pay the loan.
    // ok watch . I'm going to remove it then assist you (if needed) in recreating.
    // So right now, we have a $_SESSION[] array filled with arrays of payments nad
    // loans.  The keys to the arrays are numbers starting at zero. OK? ok

    $loanStore = clone $_SESSION['loans'][$targetLoanID];
    $paymentStore = $_SESSION['payments'][$paymentID];

    $comex = CommoditiesExchange::getInstance();

    # A class' public functions should ONLY directly aid in accomplishing the goals of the class.
    # A class' functions should NEVER be made public out of "coding convenience", as this is a sure
    # sign of improper design and a breaking of Encapsulation.

    try
    {
        $FRNs = $comex->exchange($paymentStore, $loanStore);
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
    $loanStore = CommoditiesFactory::build($loanStore->commodity->name, $FRNs->quantity);

    // Prevent a memory leak by unsetting the old loan object.
    unset($_SESSION['loans'][$targetLoanID]);
    // Store the new loan object in the session.
    $_SESSION['loans'][$targetLoanID] = $loanStore;

    // 4. Zero-out the payment.
    unset($_SESSION['payments'][$paymentID]);


    echo 'AFTER: <pre>', print_r($_SESSION, true), '</pre>';
    // 4. Redirect back to the main page.
    // FIXME: Needs a proper dynamic URL generator.
    //header('Location: http://www.phpu.cc/collabra/market/web/');
}
}