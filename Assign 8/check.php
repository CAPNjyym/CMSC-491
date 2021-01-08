<?php /* Jyym Culpepper
		CMSC 491
		Spring 2012 */

$ordernum = $_GET["order"];

if (file_exists("orders.data")){
	$orders = file("orders.data");
	for ($i=0; $i<count($orders); $i++){
		$orders[$i] = explode(";", trim($orders[$i]));
		
		if ($orders[$i][0] == $ordernum){
			$order = $orders[$i];
			
			for ($i=5; $i<count($order); $i++)
				$order[$i] = explode(",", $order[$i]);
			
			break;
		}
	}
}

if (is_array($order)){
?>
<table border="1">
	<tr>
		<th colspan="2">Shipping Information</th>
	</tr>
	<tr>
		<td>Name</td>
		<td><?php echo($order[1]); ?></td>
	</tr>
	<tr>
		<td>Address</td>
		<td><?php echo($order[2]); ?></td>
	</tr>
	<tr>
		<td>Total Cost</td>
		<td>$<?php echo($order[3]); ?></td>
	</tr>
	<tr>
		<td>Shipping Status</td>
		<td><?php echo($order[4]); ?></td>
	</tr>
</table>
<p><br />
<?php
	for ($i=5; $i<count($order); $i++){
?>
</p>
<table border="1">
	<tr>
		<th colspan="2"><?php echo($order[$i][0]); ?></th>
	</tr>
	<tr>
		<td>Catalog Number</td>
		<td><?php echo($order[$i][1]); ?></td>
	</tr>
	<tr>
		<td>Quantity Ordered</td>
		<td><?php echo($order[$i][2]); ?></td>
	</tr>
	<tr>
		<td>Cost Per Item</td>
		<td>$<?php echo($order[$i][3]); ?></td>
	</tr>
</table>
<p>
<?php
	}
?>
<br />
<input type="button" value="Track your Order"/>
<?php
	if ($order[4] == "Shipped" || $order[4] == "shipped"){
?>
<input type="button" value="Return an Item"/>
</p>
<?php
	}
}

else{
?>
Order <?php echo($ordernum); ?> does not exist.
<?php
}
?>

