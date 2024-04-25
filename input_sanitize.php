<?php
   
  

	function cleanInputs($user_input) {
		$user_input = trim($user_input);
		$user_input = stripslashes($user_input);
		$user_input = htmlspecialchars($user_input);
		return $user_input;
	}

	

?>
