<?php
	session_start();
	include_once "testlogin.php";
	redirectIfNotLoggedIn("https://127.0.0.1/");

?>
<html>
	<body>
<?php
	if(!function_exists("redirect")){
		function redirect($url){
			$h = "Location: " . $url;
			header($h);
			die();
		}
	}
	echo "<h1 style=\"text-align: right; color: red;\">Username = " . htmlspecialchars($_SESSION['username']) . "<h1/>";

	$itemName = $_SESSION['itemName'];
	$itemId = $_SESSION['itemId'];

	if(empty($itemName)){
		redirect("https://127.0.0.1/searchView.php");
	}

	//Lägg till sessionsvariebler för köp som beror på sessionNbr, antalet tidigare köp.
	if (empty($_SESSION['purchaseNbr'])){
		$purchaseNbr = 1;
		$_SESSION["purchaseNbr"] =  $purchaseNbr;
	} else {
		$purchaseNbr = $_SESSION['purchaseNbr'];
	}


	$purchaseNbr = $purchaseNbr + 1;
	$_SESSION["purchases".$purchaseNbr] =  $itemName;
	$_SESSION["purchasesId".$purchaseNbr] =  $itemId;
	$_SESSION["purchaseNbr"] = $purchaseNbr;
	echo htmlspecialchars($itemName). " has been added to cart";
	echo "</form>";
	echo "<form action='searchView.php' method='POST'>";
	echo "<input id='submit' type='submit' value='back' name= 'back'>";
	echo "</form>";
?>

	</body>
</html>
