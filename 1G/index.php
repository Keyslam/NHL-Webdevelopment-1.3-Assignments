<DOCTYPE html>
<?
	$result = 0;

	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		if (isset($_POST["calculate"])) {
			$input_1 = $_POST["input_1"];
			$input_2 = $_POST["input_2"];
			$operation = $_POST["operation"];

			switch ($operation) {
				case "add":
					$result = $input_1 + $input_2;
					break;
				case "sub":
					$result = $input_1 - $input_2;
					break;
				case "mul":
					$result = $input_1 * $input_2;
					break;
				case "div":
					$result = $input_1 / $input_2;
					break;
				case "mod":
					$result = $input_1 % $input_2;
					break;
			} 
		}
		elseif (isset($_POST["reset"])) {
			$result = 0;
		}
	}
?>

<html>
	<body>
		<form method="post">
			First number: <input type="number" name="input_1" value=<?= $result?>><br>
			Second number: <input type="number" name="input_2" value=0><br>	
			Opereration:<select name="operation">
				<option value="add">( + ) Add</option>
				<option value="sub">( - ) Subtract</option>
				<option value="mul">( * ) Multiply</option>
				<option value="div">( / ) Divide</option>
				<option value="mod">( % ) Modulo</option>
			</select>

			<br><br>

			<input type="submit" name="calculate" value="Calculate">
			<input type="submit" name="reset" value="Reset">
		</form>

		Result: <?= $result ?>
	</body>
</html>