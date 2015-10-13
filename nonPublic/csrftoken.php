<?php
function checkCSRF(){
		if(is_null($_POST['token'])){
			return false;
		}
		$token = $_POST['token'];
		if($token == session_id()){
			return true;
		}else{
			return false;
		}
	}
?>
