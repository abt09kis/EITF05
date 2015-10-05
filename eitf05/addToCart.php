<?php
	session_start();
	include_once "testlogin.php";
	redirectIfNotLoggedIn("https://127.0.0.1/");

?>
<html>
	<body>
<?php
	echo "<h1 style=\"text-align: right; color: red;\">Username = " . htmlspecialchars($_SESSION['username']) . "<h1/>";

	$itemName = $_SESSION['itemName'];
	$itemId = $_SESSION['itemId'];

	if(empty($itemName)){
		redirect("https://127.0.0.1/searchView.php");
	}
	if (empty($_SESSION['cookieNbr'])){
		$cookieNbr = 1;
		$_SESSION["cookieNbr"] =  $cookieNbr;
	} else {
		$cookieNbr = $_SESSION['cookieNbr'];
	}

	$cookieNbr = $cookieNbr + 1;
	$_SESSION["purchases".$cookieNbr] =  $itemName;
	$_SESSION["purchasesId".$cookieNbr] =  $itemId;
	$_SESSION["cookieNbr"] = $cookieNbr;

	echo htmlspecialchars($itemName). " has been added to cart";
	echo "</form>";
	echo "<form action='searchView.php' method='POST'>";
	echo "<input id='submit' type='submit' value='back' name= 'back'>";
	echo "</form>";
?>

	</body>
</html>
