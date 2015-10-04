<?php
	session_start();
	include_once "testlogin.php";
	redirectIfNotLoggedIn("https://127.0.0.1/");
?>
<html>
	<body>
<?php
	include_once "database.php";
	$database = new Database();
	echo "<table>";

	for ($x = 2; $x <= $_SESSION['cookieNbr']; $x++) {
		$username = $_SESSION["username"];
		$itemId = $_SESSION["purchasesId".$x];
		$itemName = $_SESSION["purchases".$x];
		echo "<tr><th> " . $itemName . " </th>";

		$mysqli = $database->openConnection();

		$sql = "INSERT INTO purchases (email,itemId,purchDate) VALUES ( ? , ?, NOW() )";

		$stmt = $mysqli->prepare($sql);

		if($stmt->bind_param('ss', $username, $itemId)){
			if($stmt->execute()){
				echo "<th> purchase successful </th></tr>";
			}
		}
		$stmt->free_result();
		$database->closeConnection($mysqli);
	}
	echo "</table>";
?>

	<body/>
<html/>

