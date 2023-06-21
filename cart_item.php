<?php
include_once 'customers.php';
$customerObj = new Customers();

$itemsid = $_POST['itemssel'];
$custId = $_POST['custId'];
$cartId = $_POST['cartId'];

$datos = $customerObj->createCartItem($cartId,$itemsid,$custId);
// $datos = $_GET["carts"];
// echo('datos cart item: '.$datos);
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
				<th>Sub Total Item</th>
				<th>Address Line 1</th>
				<th>Address City</th>
				<th>Address State</th>
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
					<td><?php echo $dato->AddsLine ?></td>
					<td><?php echo $dato->City ?></td>
					<td><?php echo $dato->AddsState ?></td>

				</tr>
				<?php $total = $dato->SubTotal+=$dato->SubTotal ?>
			<?php } /*Cerrar llave, fin de foreach*/ ?>
			<h2>TOTAL for cart id <?php echo $dato->Cart ?>: <?php echo $total ?></h2>

			<a href="practice3.php">All Customers</a>
		</tbody>				
	</table>
</body>
</html>
