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



	function updateUser($name, $phone, $email, $additionalEmail){
		$name = cleanInputs($name);
        $phone = cleanInputs($phone);
        $email = cleanInputs($email);
        $additionalEmail = cleanInputs($additionalEmail);

        $mysqli = new mysqli('localhost', 'team28', 'RiddleStars', 'waph_team');

		if($mysqli->connect_errno) {
	 		printf("Database connection failed: %s\n", $mysqli->connect_error);
	 		exit();
		}
		if ( !preg_match("/[^\s@]+@[^\s@]+\.[^\s@]+/", $email) || 
            !preg_match("/[^\s@]+@[^\s@]+\.[^\s@]+/", $additionalEmail) || 
            !preg_match("/[0-9]{3}-[0-9]{3}-[0-9]{4}/", $phone)) {
?>
                <h2> Invalid inputs. Please go back to <a href="userRegistrationForm.php">registration form</a></h2>
<?php
        } else {
		$prepared_sql = "UPDATE users SET  name = ?, phone = ?, email = ?, additionalEmail = ? WHERE username = ?";
		$stmt = $mysqli->prepare($prepared_sql);
		$stmt->bind_param("sssss", $name, $phone, $email, $additionalEmail, $_SESSION["username"]);
		$success = $stmt->execute();
		
		
		if($success){
			?>
			<h2> Successfully updated! </h2>
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

	

 if(isset($_POST["name"]) && isset($_POST["phone"]) && isset($_POST["email"]) && isset($_POST["additionalEmail"])) {

        
        $name = cleanInputs($_POST["name"]);
        $phone = cleanInputs($_POST["phone"]);
        $email = cleanInputs($_POST["email"]);
        $additionalEmail = cleanInputs($_POST["additionalEmail"]);

        if ( !preg_match("/[^\s@]+@[^\s@]+\.[^\s@]+/", $email) || 
            !preg_match("/[^\s@]+@[^\s@]+\.[^\s@]+/", $additionalEmail) || 
            !preg_match("/[0-9]{3}-[0-9]{3}-[0-9]{4}/", $phone)) {
?>
                <h2> Invalid inputs. Please go back to <a href="userRegistrationForm.php">registration form</a></h2>
<?php
        } else {
            updateUser($_POST["name"], $_POST["phone"], $_POST["email"], $_POST["additionalEmail"]);
        }
    } else {
?>
    <h2> Invalid inputs. Please go back to <a href="updateDetails.php">update form</a></h2>
<?php
    }
?>

