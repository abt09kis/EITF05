<?php
	session_start();
	include_once "testlogin.php";
	include_once "../nonPublic/csrftoken.php";
	include_once "database.php";
	redirectIfNotLoggedIn("https://127.0.0.1/");

	echo "<html>";
	echo "<body>";

	echo "<h1 style=\"text-align: right; color: red;\">Username = " . htmlspecialchars($_SESSION['username']) . "<h1/>";

	//Sök i databasen efter produkten, visa resultat. 
	$database = new Database();
	$mysqli = $database->openConnection();

	$sql = "SELECT * FROM items WHERE itemName = ?";
	$stmt = $mysqli->prepare($sql);
	$search = strip_tags($_POST['searchField']);

	echo "<div>";
	echo "<table style='width:20%' id = 'itemTable'>";
	if($stmt->bind_param('s', $search)){
		if($stmt->execute()){
			$itemId = NULL;
			$itemName = NULL;
			$cost = NULL;
			$stmt->bind_result($itemId, $itemName,$cost);

			print "<tr><th>Name</th><th>cost</th></tr>";
			if($stmt->fetch()) {
				    print "</th><th>" . $itemName . "</th><th>" . $cost . "</th></tr>";
			}else{
			    print " 0 results for search: " . htmlspecialchars($search);
			}
			$stmt->free_result();
		}
	}

	echo "</table>";


	echo "<div>";
	if(!is_null($itemName)){
		$_SESSION['itemId'] = $itemId;
		$_SESSION['itemName'] = $itemName;
		$database->closeConnection($mysqli);

		echo "<form action='addToCart.php' method='POST'>";
		echo "<input id='submit' type='submit' value='Add to cart' name= 'Add to cart'>";
		echo "<input type=\"hidden\" name=\"token\" value=\"" .  session_id() . "\"/>";
		echo "</form>";
		echo "<form action='checkoutView.php' method='POST'>";
		echo "<input id='submit' type='submit' value='Checkout' name= 'Checkout'>";
		echo "<input type=\"hidden\" name=\"token\" value=\"" .  session_id() . "\"/>";
		echo "</form>";
		echo "</form>";
	}else{
		echo "<br/>";
	}
	echo "<form action='searchView.php' method='POST'>";
	echo "<input id='submit' type='submit' value='back' name= 'back'>";
	echo "</form>";

	echo "</div>";
	echo "</div>";
	echo "</body>";
	echo "</html>";
?>
