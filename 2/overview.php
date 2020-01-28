<DOCTYPE html>
<?
	session_start();

	$username = $_SESSION["username"];
	$password = $_SESSION["password"];
	$product = $_SESSION["product"];
	$street = $_SESSION["street"];
	$number = $_SESSION["number"];
	$city = $_SESSION["city"];
?>
<html>
	<body>
		<h1>Besteloverzicht</h1>

		Username: <br>
		<input type="text" disabled value=<?= $username ?>><br>

		Password: <br>
		<input type="text" disabled value=<?= $password ?>><br>

		Product: <br>
		<input type="text" disabled value=<?= $product ?>><br>

		Street: <br>
		<input type="text" disabled value=<?= $street ?>><br>

		Number: <br>
		<input type="text" disabled value=<?= $number ?>><br>

		City: <br>
		<input type="text" disabled value=<?= $city ?>><br>

		<br>

		<form method="GET" action="orderComplete.php">
			<input type="submit" name="submit" value="Submit">
			<input type="submit" name="cancel" value="Cancel">
		</form>
	</body>
</html>