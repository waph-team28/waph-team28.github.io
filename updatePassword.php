<?php
require "input_sanitize.php";
       require "session_auth.php";
	startSession();
       checkAuthentication();
       $token = $_POST["nocsrftoken"];
	if (!isset($token) or ($token!=$_SESSION["nocsrftoken"])){
	echo "CSRF Attack is detected";
	die();
	}



	function updateUser($password){

        $password = cleanInputs($password);

        if (!preg_match("/^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#$%^&])[\w!@#$%^&]{8,}$/s", $password)) {
		?>
		                <h2> Invalid inputs. Please go back to <a href="changePassword.php">password change form</a></h2>
		<?php
        } else {
        $mysqli = new mysqli('localhost', 'team28', 'RiddleStars', 'waph_team');

		if($mysqli->connect_errno) {
	 		printf("Database connection failed: %s\n", $mysqli->connect_error);
	 		exit();
		}
		$prepared_sql = "UPDATE users SET  password = md5(?) WHERE username = ?";
		$stmt = $mysqli->prepare($prepared_sql);
		$stmt->bind_param("ss", $password, $_SESSION["username"]);
		$success = $stmt->execute();
		
		
		if($success){
			?>
			<h2> Successfully updated the password! </h2>
			<a href="/index.php">Home</a>
			<?php

		}else{
			?>
			<h2> Cannot update</h2>
			<a href="/index.php">Home</a>
			<?php
		}
		}
		
		
	}

	
	if(isset($_POST["password"])) {

        
        $password = cleanInputs($_POST["password"]);

        if (!preg_match("/^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#$%^&])[\w!@#$%^&]{8,}$/s", $password)) {
?>
                <h2> Invalid inputs. Please go back to <a href="changePassword.php">password change form</a></h2>
<?php
        } else {
            updateUser($_POST["password"]);
        }
    } else {
?>
    <h2> Invalid inputs. Please go back to <a href="changePassword.php">password change form</a></h2>
<?php
    }
?>
