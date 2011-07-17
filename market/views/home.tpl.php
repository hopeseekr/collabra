<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title>Collabra Market</title>
		<link rel="stylesheet" href="css/main.css"/>
	</head>
	<body>
		<div class="marketbanner">
		</div>
		<div class="bodyContent">
			<p id="abstract">
				Collabra Market's goal is to facilitate the exchange of commodities by
				registering loans in one commodity and paying them with another.
			</p>
			<div id="payment_basket">
				<h2>Create a payment basket</h2>
				<form method="post" action="?action=<?php echo ActionsList::CREATE_PAYMENT_BASKET; ?>">
					<fieldset>
						<div class="required">
							<label for="payment_commodity">Commodity:</label>
							<select id="payment_commodity" name="payment_commodity">
								<!-- TODO: This needs to be dynamically-populated! -->
								<option> --- Select --- </option>
								<option value="Silver">Silver</option>
								<option value="Federal Reserve Note">FRN (a.k.a. USD)</option>
							</select>
						</div>

						<div class="required">
							<label for="payment_quantity">Quantity:</label>
							<input type="text" id="payment_quantity" name="payment_quantity"/>
						</div>
						<div><input type="submit" class="inputSubmit" value="add"/></div>
					</fieldset>
				</form>
			</div>
			<div id="register_loan">
				<h2>Register a new loan</h2>
				<form method="post" action="?action=<?php echo ActionsList::REGISTER_LOAN; ?>">
					<fieldset>
						<div class="required">
							<label for="loan_commodity">Denominated Commodity:</label>
							<select id="loan_commodity" name="loan_commodity">
								<!-- TODO: This needs to be dynamically-populated! -->
								<option> --- Select --- </option>
								<option value="Silver">Silver</option>
								<option value="Federal Reserve Note">FRN (a.k.a. USD)</option>
							</select>
						</div>

						<div class="required">
							<label for="loan_quantity">Amount:</label>
							<input type="text" id="loan_quantity" name="loan_quantity"/>
						</div>

						<div class="required">
							<label for="loan_term">Loan term:</label>
							<input type="text" id="loan_term" name="loan_term"/>
						</div>

						<div class="required">
							<label for="loan_interest_rate">Interest rate:</label>
							<input type="text" id="loan_interest_rate" name="loan_interest_rate" size="6"/>
						</div>
						<div><input type="submit" class="inputSubmit" value="add"/></div>
					</fieldset>
				</form>
			</div>
<?php
// Only show if both loans and payments are registered.
if (isset($_SESSION['loans']) && isset($_SESSION['payments']))
{
?>
			<div id="make_payment">
				<h2>Make a payment</h2>
				<form method="post" action="make_payment.php">
					<fieldset>
						<div class="required">
							<label for="target_loan">Target loan:</label>
							<select id="target_loan" name="target_loan">
								<!-- TODO: This needs to be dynamically-populated! -->
								<option value=""> --- Select --- </option>
<?php
	// TODO: $loan needs to be a Loan model.
	print_r($_SESSION);
	foreach ($_SESSION['loans'] as $id => $loan)
	{
        print_r($loan);
		$loanLine = sprintf('%s (%.2f)', 
		                    $loan['basket']->getMeasureName(),
		                    $loan['basket']->getTotalValuation());
?>
								<option value="<?php echo $id; ?>"><?php echo $loanLine; ?></option>
<?php
	}
?>
							</select>
						</div>

						<div class="required">
							<label for="payment_commodity">Payment commodity:</label>
							<select id="payment_commodity" name="payment_commodity">
								<!-- TODO: This needs to be dynamically-populated! -->
								<option value=""> --- Select --- </option>
								<option>Silver</option>
								<option>FRN (a.k.a. USD)</option>
							</select>
						</div>

						<div class="required">
							<label for="payment_quantity">Amount:</label>
							<input type="text" id="loan_quantity" name="loan_quantity"/>
						</div>
						<div><input type="submit" class="inputSubmit" value="add"/></div>
					</fieldset>
				</form>
			</div>
<?php
}
?>
		</div>
	</body>
</html>

