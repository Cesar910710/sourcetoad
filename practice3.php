<?php

include_once 'customers.php';
$customerObj = new Customers();

$customers = $customerObj->getAllCustomer();
?>

<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<title>Tabla estática</title>
	<style>
		table, th, td {
		    border: 1px solid black;
		}
	</style>
</head>
<body>
	<table>
		<thead>
			<tr>
				<th>First Name</th>
				<th>Last Name</th>
				<th>Add items</th>
				<th>carts</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach($customers as $customer){ /*Notar la llave que dejamos abierta*/ ?>
				<tr>
					<td><?php echo $customer->first_name ?></td>
					<td><?php echo $customer->last_name ?></td>
					<td>
						<a href="create_cart.php?custoid=<?php echo $customer->id ?>">Buy Items</a>
					</td>
					<td>
						<a href="customer_carts.php?id=<?php echo $customer->id ?>">Carts</a>
					</td>
				</tr>
			<?php } /*Cerrar llave, fin de foreach*/ ?>

		</tbody>
	</table>
</body>
</html>