<DOCTYPE html>
<?
	session_start();

	$placed = true;

	if (isset($_GET["cancel"])) {
		$placed = false;
	}

	$username = $_SESSION["username"];
	$password = $_SESSION["password"];
	$product = $_SESSION["product"];
	$street = $_SESSION["street"];
	$number = $_SESSION["number"];
	$city = $_SESSION["city"];

	session_destroy();
?>
<html>
	<body>
		<? if ($placed) { ?>
			Your order has been placed
			
			<br> <br>

			Username: <?= $username?> 
			Password: <?= $password?> 
			Product: <?= $product?> 
			Street: <?= $street?> 
			Number: <?= $number?> 
			City: <?= $city?> 
		<? } else { ?>
			Your order has been cancelled
		<? } ?>
	</body>
</html>