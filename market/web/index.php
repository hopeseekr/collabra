<?php
/*
Goal: To develop the basic HTML for the main widgets.
 * Build the home page.
     o Brief intro on what Commodity Market is about. (just fill w/ Lorem Ipsum for now).
     o Form to add quantities to a silver basket.
     o Form to register a loan in FRNs.
     o Form to secure a commodity for a monthly loan payment.
 */
// First thing you have to do when using sessions is to start a session.
session_start();


?>
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
				Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt 
				ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco 
				laboris nisi ut aliquip ex ea commodo consequat.
			</p>
			<div id="payment_basket">
				<h2>Create a payment basket</h2>
				<form method="post" action="create_payment_basket.php">
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
				<form method="post" action="register_loan.php">
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
								<option> --- Select --- </option>
							</select>
						</div>

						<div class="required">
							<label for="payment_commodity">Payment commodity:</label>
							<select id="payment_commodity" name="payment_commodity">
								<!-- TODO: This needs to be dynamically-populated! -->
								<option> --- Select --- </option>
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

