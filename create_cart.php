<?php
include_once 'customers.php';
$customerObj = new Customers();

if (empty($_GET["custoid"])) {
		exit("No hay id");
	}

if(!isset($_POST['add'])){
	$custoid = $_GET['custoid'];
	$data = $customerObj->CreateCart($custoid);
	$cart = $data["cart"];
	$items = $data["items"];
}

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
	<form action="cart_item.php" method="post">
		<table>
			<thead>
				<tr>
					<th>Item Name</th>
					<th>Quantity</th>
					<th>Price</th>
					<th>Agregar</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach($items as $item){ /*Notar la llave que dejamos abierta*/ ?>
					<?php if($item->quantity > 0){ ?>
					<tr>
						<td><?php echo $item->name ?></td>
						<td><?php echo $item->quantity ?></td>
						<td><?php echo $item->price ?></td>
						<!-- <td>
							<a href="cart_item.php?cartid=<?php echo $cart?>&itemid=<?php echo $item->id?>&custoid=<?php echo $custoid?>">Add Item</a>
						</td> -->
						<td>
              				<input type="checkbox" name="itemssel[]" value="<?php echo $item->id;?>">
          				</td>
					</tr>
					<?php } /*Cerrar llave, fin de if*/ ?>
				<?php } /*Cerrar llave, fin de foreach*/ ?>

			</tbody>
		</table>
		<input type="hidden" id="custId" name="custId" value="<?php echo $custoid;?>">
		<input type="hidden" id="cartId" name="cartId" value="<?php echo $cart;?>">
		<input type="submit" name="add" class="btn btn-primary" style="float:center;" value="Add">
	</form>
</body>
</html>