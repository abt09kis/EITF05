<?php
	session_start();
	include_once "testlogin.php";
	redirectIfNotLoggedIn("https://127.0.0.1/");
?>
<html>
	<body>

<?php
	include_once "../nonPublic/csrftoken.php";
	echo "If confirmed, the following items will be purchased:<br/>";
	echo "<table>";
	for ($x = 2; $x <= $_SESSION['cookieNbr']; $x++) {
		$username = $_SESSION["username"];
		$itemId = $_SESSION["purchasesId".$x];
		$itemName = $_SESSION["purchases".$x];
		echo "<tr><th> " . $itemName . " </th>";
	}
	echo "</table>";
	echo "<br/>";
?>
		<form action="buyItems.php" method="POST">
			<input id="submit" type="submit" value="Confirm Purchase">
<?php
	echo "<input type=\"hidden\" name=\"token\" value=\"" .  session_id() . "\"/>";
?>
		</form>

		<form action="searchView.php" method="POST">
			<input id="submit" type="submit" value="Continue Shopping">
<?php
	echo "<input type=\"hidden\" name=\"token\" value=\"" .  session_id() . "\"/>";
?>
		</form>

	<body/>

<html/>
