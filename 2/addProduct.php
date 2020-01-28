<DOCTYPE html>
<?
	$username = $_GET["username"];
	$password = $_GET["password"];
?>
<html>
	<body>
		<form method="POST" action="addAddress.php">
			<input type="hidden" name="username" value=<?= $username ?>>
			<input type="hidden" name="password" value=<?= $password ?>>

			<select name="product">
				<option value="ball">Ball</option>
				<option value="cookie">Cookie</option>
				<option value="spooderboi">Spooderboi</option>
			</select>

			<br>

			<input type="submit" value="Next">
		</form>

		Username: <br>
		<input type="text" disabled value=<?= $username ?>><br>
		
		Password: <br>
		<input type="text" disabled value=<?= $password ?>><br>
	</body>
</html>