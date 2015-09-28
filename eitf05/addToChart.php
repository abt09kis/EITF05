
<?php

$cookieNbr = $_COOKIE['cookieNbr'];
setcookie("purchases[$cookieNbr]", $_SESSION["itemName"]);
setcookie("cookieNbr", $cookieNbr + 1);

echo "strip_tags($_SESSION["itemName"]) .  'has been added to cart' ";
echo "</form>";
echo "<form action='search.html' method='POST'>";
echo "<input id='submit' type='submit' value='back' name= 'back'>";
echo "</form>";

?>
