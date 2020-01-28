<DOCTYPE html>
<?
	$username = $_POST["username"];
	$password = $_POST["password"];
	$product = $_POST["product"];
?>
<html>
	<body>
		<form method="POST" action="makeSession.php">
			<input type="hidden" name="username" value=<?= $username ?>>
			<input type="hidden" name="password" value=<?= $password ?>>
			<input type="hidden" name="product" value=<?= $product ?>>

			Street: <br>
			<input type="text" name="street"> <br>
	
			Number: <br>
			<input type="text" name="number"> <br>

			City: <br>
			<input type="text" name="city"> <br>

			<br>
			
			<input type="submit" value="Next">
		</form>

		Username: <br>
		<input type="text" disabled value=<?= $username ?>><br>

		Password: <br>
		<input type="text" disabled value=<?= $password ?>><br>

		Product: <br>
		<input type="text" disabled value=<?= $product ?>><br>
	</body>
</html>