
<?php

session_start();

if (is_null($_COOKIE['cookieNbr'])){
  print "null check ";
  $cookieNbr = 1;
  print $cookieNbr;
  setcookie("cookieNbr", $cookieNbr);
} else {
  $cookieNbr = $_COOKIE['cookieNbr'];

  print "cookieNbr";
  print $cookieNbr;
}

print $_SESSION["itemName"];

setcookie(purchases[$cookieNbr + 1], $_SESSION["itemName"]);
setcookie("cookieNbr", $cookieNbr + 1);

echo $_SESSION["itemName"]. " has been added to cart";
echo "</form>";
echo "<form action='search.html' method='POST'>";
echo "<input id='submit' type='submit' value='back' name= 'back'>";
echo "</form>";

?>
