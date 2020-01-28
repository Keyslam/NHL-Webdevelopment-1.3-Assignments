<?
session_start();

$_SESSION["username"] = $_POST["username"];
$_SESSION["password"] = $_POST["password"];

$_SESSION["product"] = $_POST["product"];

$_SESSION["street"] = $_POST["username"];
$_SESSION["number"] = $_POST["number"];
$_SESSION["city"] = $_POST["city"];

header("Location: overview.php"); 
?>