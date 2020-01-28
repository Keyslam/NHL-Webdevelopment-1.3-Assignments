<DOCTYPE html>
<?
	$name = "";
	$description = "";
	$price = 0.00;
	$category = "";
	$emailSupplier = "";
	$soldOut = true;

	$hasError = false;
	$errorMessage = "";

	if ($_SERVER["REQUEST_METHOD"] == "POST")  {
		// Name
		$name = filter_input(INPUT_POST, "name", FILTER_SANITIZE_STRING);

		if (empty($name)) {
			$errorMessage .= "Name is required<br>";
			$hasError = true;
		}
	
		if (strlen($name) < 3 || strlen($name) > 50) {
			$errorMessage .= "Name length isn't an allowed size (3 - 50)<br>";
			$hasError = true;
		}

		// Description
		$description = filter_input(INPUT_POST, "description", FILTER_SANITIZE_STRING);

		if (strlen($description) > 2048) {
			$errorMessage .= "Description length is too long (max 2048)<br>";
			$hasError = true;
		}

		// Price
		$price = filter_input(INPUT_POST, "price", FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);

		// Category
		if (isset($_POST["category"])) {
			$category = $_POST["category"];
		} else {
			$errorMessage .= "Category wasn't set<br>";
			$hasError = true;
		}

		// Email
		if (isset($_POST["emailSupplier"])) {
			$emailSupplier = $_POST["emailSupplier"];

			if (!filter_input(INPUT_POST, "emailSupplier", FILTER_SANITIZE_EMAIL)) {
				$errorMessage .= "Email isn't legitimate<br>";
				$hasError = true;
			}
		}
		
		// Sold out
		if (isset($_POST["soldOut"])) {
			$soldOut = $_POST["soldOut"];
		} else {
			$soldOut = false;
		}


		// Error
		if ($hasError) {
			echo $errorMessage;
		} else {
			echo "Success";
		}
	}
?>

<html>
	<body>
		<form method="POST">
			Name: <input type="text" pattern=".{3, 50}" name="name" required value=<?= $name ?>><br>
			Description: <input type="text" name="description" maxlength="2048" value=<?= $description ?>><br>
			Price: <input type="number" name="price" required value=<?= $price ?>><br>
			Category: <select name="category" name="category">
				<option value="food" <? if ($category == "food") echo "selected"; ?>>Food</option>
				<option value="electronics" <? if ($category == "electronics") echo "selected"; ?>>Electronics</option>
				<option value="clothing" <? if ($category == "clothing") echo "selected"; ?>>Clothing</option>
				<option value="flowers" <? if ($category == "flowers") echo "selected"; ?>>Flowers</option>
			</select><br>
			Email supplier: <input type="email" name="emailSupplier" required value=<?= $emailSupplier ?>><br>
			Sold out: <input type="checkbox" name="soldOut" <? if ($soldOut) echo "checked"; ?>><br>
			<br>
			<input type="submit" value="Submit" name="submit">
		</form>	
	</body>
</html>