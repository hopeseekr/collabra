<?php
/*
Goal: To develop the basic HTML for the main widgets.
 * Build the home page.
     o Brief intro on what Commodity Market is about. (just fill w/ Lorem Ipsum for now).
     o Form to add quantities to a silver basket.
     o Form to register a loan in FRNs.
     o Form to secure a commodity for a monthly loan payment.
 */
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title>Collabra Market</title>
		<link rel="stylesheet" href="css/main.css"/>
	</head>
	<body>
		<h1>Collabra Market</h1>
		<p id="abstract">
			Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt 
			ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco 
			laboris nisi ut aliquip ex ea commodo consequat.
		</p>
		<div id="payment_basket">
			<h2>Create a payment basket</h2>
			<form method="post" action="FFFFFUUUUUU">
				<fieldset>
					<div class="required">
						<label for="payment_commodity">Commodity:</label>
						<select id="payment_commodity" name="payment_commodity">
							<!-- TODO: This needs to be dynamically-populated! -->
							<option> --- Select --- </option>
							<option>Silver</option>
							<option>FRN (a.k.a. USD)</option>
						</select>
					</div>
				</fieldset>
			</form>
		</div>
	</body>
</html>
