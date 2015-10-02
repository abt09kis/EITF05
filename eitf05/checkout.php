<?php

include_once database.php;
session_start();

echo "<table>";
for ($x = 2; $x <= $_SESSION['cookieNbr']; $x++) {

    $username = $_SESSION["username"];
    $itemId = $_SESSION["purchasesId".$x];
    $itemName = $_SESSION["purchases".$x];

    echo "<tr><th> " . $itemName . " </th>";

    database->openConnection();

  $sql = "INSERT INTO purchases (email,itemId,purchDate) VALUES ( ? , ?, NOW() )";

  $stmt = $mysqli->prepare($sql);

  if($stmt->bind_param('ss', $username, $itemId)){
    if($stmt->execute()){

        echo "<th> purchase successful </th></tr>";
    }
  }
  $stmt->free_result();
  database->closeConnection();

}
echo "</table>";


?>
