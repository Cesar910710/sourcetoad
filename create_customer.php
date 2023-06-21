<?php
  // Include database file
  include_once 'customers.php';
  $customerObj = new Customers();
  // Insert Record in customer table
  if(isset($_POST['submit'])) {
    $customerObj->createCustomer($_POST);
  }
?>

<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<title>Register a New Customer</title>
</head>
<body>
	<form action="create_customer.php" method="post">
		<label for="first_name">First Name</label>
		<input type="text" id="first_name" name="first_name" required placeholder="Customer First Name">
		<br>
		<br>
		<label for="last_name">Last Name</label>
		<input type="text" id="last_name" name="last_name" required placeholder="Customer Last Name">
		<br>
		<br>
		<label for="line_1">Line One</label>
		<input type="text" id="line_1" name="line_1" required placeholder="Customer Line One">
		<br>
		<br>
		<label for="line_2">Line Two</label>
		<input type="text" id="line_2" name="line_2" required placeholder="Customer Line Two">
		<br>
		<br>
		<label for="city">Addres City</label>
		<input type="text" id="city" name="city" required placeholder="Customer Address City">
		<br>
		<br>
		<label for="state">Addres State</label>
		<input type="text" id="state" name="state" required placeholder="Customer Address State">
		<br>
		<br>
		<label for="zip">Zip</label>
		<input type="text" id="zip" name="zip" required placeholder="ZIP">
		<br>
		<br>
        <input type="submit" name="submit" class="btn btn-primary" style="float:center;" value="Submit">
	</form>
</body>
</html>