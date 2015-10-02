<?php
include_once database.php;

  session_start();

  echo "<html>";
  echo "<body>";
  echo "<table style='width:100%' id = 'itemTable'>";

  database->openConnection();

    $sql = "SELECT * FROM items WHERE itemName = ?";

    $stmt = $mysqli->prepare($sql);

    $search = strip_tags($_POST['searchField']);

    if($stmt->bind_param('s', $search)){
      if($stmt->execute()){
        $itemId = NULL;
        $itemName = NULL;
        $cost = NULL;
        $stmt->bind_result($itemId, $itemName,$cost);

        print "<tr><th>Id</th><th>Name</th><th>cost</th></tr>";

        if($stmt->fetch()) {

            print "<tr><th>".  $itemId ."</th><th>". $itemName."</th><th>". $cost."</th></tr>";

        }else{

            print " 0 results for search: " . htmlspecialchars($search);

        }
      }
    }

    $_SESSION['itemId'] = $itemId;
    $_SESSION['itemName'] = $itemName;

    $stmt->free_result();
    database->closeConnection();


    echo "</table>";
    echo "<form action='addToCart.php' method='POST'>";
    echo "<input id='submit' type='submit' value='Add to cart' name= 'Add to cart'>";
    echo "</form>";
    echo "<form action='checkout.php' method='POST'>";
    echo "<input id='submit' type='submit' value='Checkout' name= 'Checkout'>";
    echo "</form>";
    echo "</form>";
    echo "<form action='search.html' method='POST'>";
    echo "<input id='submit' type='submit' value='back' name= 'back'>";
    echo "</form>";
    echo "</body>";
    echo "</html>";

  ?>
