<?php
include_once 'customers.php';
$customerObj = new Customers();

if (empty($_GET["id"])) {
	exit("No hay id");
}
$custoid = $_GET['id'];
$datos = $customerObj->getCustomerCarts($custoid);
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
				<th>Customer</th>
				<th>Cart ID</th>
				<th>Item</th>
				<th>Item Quantity</th>
				<th>Item Price</th>
				<th>Num Items</th>
				<th>Sub Total</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach($datos as $dato){ /*Notar la llave que dejamos abierta*/ ?>
				<tr>
					<td><?php echo $dato->Customer ?></td>
					<td><?php echo $dato->Cart ?></td>
					<td><?php echo $dato->ItemName ?></td>
					<td><?php echo $dato->ItemQuanty ?></td>
					<td><?php echo $dato->ItemPrice ?></td>
					<td><?php echo $dato->NumItems ?></td>
					<td><?php echo $dato->SubTotal ?></td>

				</tr>
			<?php } /*Cerrar llave, fin de foreach*/ ?>

		</tbody>
	</table>
</body>
</html>
