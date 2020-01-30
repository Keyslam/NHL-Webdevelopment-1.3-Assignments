<DOCTYPE html>
<?
    $host = "localhost";
    $dbName = "crud";
    $dns = "mysql:host=$host;dbname=$dbName";
    $username = "root";
    $password = "";

	$name = "";
	$description = "";
	$price = 0.00;
	$category = "";
	$emailSupplier = "";
	$soldOut = true;

	$hasError = false;
	$errorMessage = "";

	if ($_SERVER["REQUEST_METHOD"] == "POST")  {
		if (isset($_POST["update"])) {
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
				$conn = null;

				try {
					$conn = new PDO($dns, $username, $password);

					$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				
					$query = "UPDATE Product SET Name=:Name, Description=:Description, Price=:Price, SupplierEmail=:SupplierEmail, SoldOut=:SoldOut, Category_ID=:Category_ID WHERE ID=:ID";
				
					$cmd = $conn->prepare($query);
					$cmd->bindParam(":Name", $name);
					$cmd->bindParam(":Description", $description);
					$cmd->bindParam(":Price", $price);
					$cmd->bindParam(":SupplierEmail", $emailSupplier);
					$cmd->bindParam(":SoldOut", $soldOut, PDO::PARAM_BOOL);
					$cmd->bindParam(":Category_ID", $category);
					$cmd->bindParam(":ID", $_POST["ID"]);
					$cmd->execute();
				} catch (PDOException $ex) {
					echo "Connection failed:  $ex";
				} finally {
					if ($conn != null) {
						$conn = null;
					}
				}
			}
		} elseif (isset($_POST["delete"])) {
			$conn = null;

			try {
				$conn = new PDO($dns, $username, $password);

				$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			
				$query = "DELETE FROM Product WHERE ID=:ID";
			
				$cmd = $conn->prepare($query);
				$cmd->bindParam(":ID", $_POST["ID"]);
				$cmd->execute();
			} catch (PDOException $ex) {
				echo "Connection failed:  $ex";
			} finally {
				if ($conn != null) {
					$conn = null;
				}
			}
		} elseif (isset($_POST["add"])) {
			$conn = null;

			try {
				$conn = new PDO($dns, $username, $password);

				$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			
				$query = "INSERT INTO Product (Category_ID) VALUES('1')";
			
				$cmd = $conn->prepare($query);
				$cmd->execute();
			} catch (PDOException $ex) {
				echo "Connection failed:  $ex";
			} finally {
				if ($conn != null) {
					$conn = null;
				}
			}
		}
	}

	$conn = null;

    try {
        $conn = new PDO($dns, $username, $password);

        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
        $query_select = "SELECT Product.ID, Product.Name, Product.Description, Product.Price, Product.SupplierEmail, Product.SoldOut, Category.Name AS Category FROM Product INNER JOIN Category ON Product.Category_ID=Category.ID ORDER BY Product.Name ASC";
    
        $cmd_select = $conn->prepare($query_select);
        $cmd_select->execute();
		$cmd_select->setFetchMode(PDO::FETCH_ASSOC);

		$results = $cmd_select->fetchAll();
		

		$query_categories = "SELECT ID, Name FROM Category";

		$cmd_categories = $conn->prepare($query_categories);
        $cmd_categories->execute();
		$cmd_categories->setFetchMode(PDO::FETCH_ASSOC);

		$categories = $cmd_categories->fetchAll();
    } catch (PDOException $ex) {
        echo "Connection failed:  $ex";
    } finally {
        if ($conn != null) {
            $conn = null;
        }
    }
?>

<html>
	<body>
		<table>
			<tr>
				<th>Name</th>
				<th>Description</th>
				<th>Price</th>
				<th>Category</th>
				<th>Email Supplier</th>
				<th>Sold out</th>

				<th>Update</th>
				<th>Delete</th>
			</tr>
			<? foreach ($results as $result) { ?>
				<tr>
					<form method="POST" name="form">
						<td><input type="text" pattern=".{3, 50}" name="name" required value="<?= $result["Name"];?>"></td>
						<td><input type="text" name="description" maxlength="5000" value="<?= $result["Description"];?>"></td>
						<td><input type="number" name="price" required minvalue="0" step="0.01" value=<?= $result["Price"];?>></td>
						<td>
							<select name="category">
								<? foreach ($categories as $category) { ?>
									<option value=<?= $category["ID"]?> <? if ($result["Category"] == $category["Name"]) echo "selected=selected"; ?>> <?= $category["Name"]?> </option>
								<? } ?>
							</select>
						</td>
						<td><input type="email" name="emailSupplier" required value=<?= $result["SupplierEmail"] ?>></td>
						<td><input type="checkbox" name="soldOut" <? if ($result["SoldOut"] == "1") echo "checked"; ?>></td>

						<td><input type="submit" name="update" value="Update"></td>
						<td><input type="submit" name="delete" value="Delete" formnovalidate></td>

						<input type="hidden" name="ID" value=<?= $result["ID"]?>>
					</form>
				</tr>
			<? } ?>
		</table>

		<form method="POST">
			<input type="submit" name="add" value="Add">
		</form>	
	</body>
</html>