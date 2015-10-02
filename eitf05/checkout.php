<?php
session_id('test');
session_start();
ini_set('display_errors',1);


echo "<tr><th> Id </th><th> Name </th><th> Cost </th></tr>";

for ($x = 1; $x <= $_SESSION['cookieNbr']; $x++) {

    //$username = $_SESSION["username"];
    $username = "david@me.com";
    $itemId = $_SESSION["purchasesId".$x];

    echo "<tr><th>" . $_SESSION["purchases".$x] . "</th></tr>";

$sql_user = "root";
$sql_host = "localhost";
$sql_pass = "root";


  $mysqli = new mysqli($sql_host, $sql_user, $sql_pass, "EITF05");
  if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
  }

  $sql = "INSERT INTO purchases ('email','itemId') VALUES( ? , ? )";

  $stmt = $mysqli->prepare($sql);

  if($stmt->bind_param('ss', $username, $itemId)){
    if($stmt->execute()){

        echo "purchase successfull";
    }
  }
}

echo "<form action='purchase.php' method='POST'>";
echo "<input id='submit' type='submit' value='Buy' name= 'Buy'>";
echo "</form>";

?>
