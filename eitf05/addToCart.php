
<?php
session_id('test');
session_start();

ini_set('display_errors',1);

if (empty($_SESSION['cookieNbr'])){

  $cookieNbr = 1;
  $_SESSION["cookieNbr"] =  $cookieNbr;

} else {

  $cookieNbr = $_SESSION['cookieNbr'];
}

$cookieNbr = $cookieNbr + 1;
$_SESSION["purchases".$cookieNbr] =  $_SESSION["itemName"];
$_SESSION["cookieNbr"] = $cookieNbr;

echo $_SESSION["itemName"]. " has been added to cart";
echo "</form>";
echo "<form action='search.html' method='POST'>";
echo "<input id='submit' type='submit' value='back' name= 'back'>";
echo "</form>";

?>
