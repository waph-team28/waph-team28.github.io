<?php
	$lifetime = 15*60;
    $path = "/";
    $domain = "192.167.9.238";
    $secure = TRUE;
    $httponly = TRUE;
    session_set_cookie_params($lifetime, $path, $domain, $secure, $httponly);
	session_start();  
	if(isset($_POST["username"]) && isset($_POST["password"])) {

		if (checklogin_mysql($_POST["username"], $_POST["password"])) {
			$_SESSION["authenticated"] = TRUE;
			$_SESSION["username"] = $_POST['username'];
			$_SESSION["browser"] = $_SERVER["HTTP_USER_AGENT"];
			$_SESSION["role"] = "superuser";
		} else {
			session_destroy();
			echo "<script>alert('Invalid username or password');window.location='form.php';</script>";
			die();
		}
	}

	if(!isset($_SESSION['authenticated']) || $_SESSION['authenticated'] != TRUE) {
		session_destroy();
		echo "<script>alert('You have not logged in. Please login first');</script>";
		header("Refresh:0;url=loginform.php");
		die();
	}

	if($_SESSION["browser"] != $_SERVER["HTTP_USER_AGENT"]){
	    echo "<script>alert('session compromised !! redirecting to login page')</script>";
	    header("Refresh:0; url=loginform.php");
	    die();
    }

    if($_SESSION["role"] != "superuser"){
	    echo "<script>alert('You are not an admin')</script>";
	    header("Refresh:0; url=loginform.php");
	    die();
    }
    
	

  	function checklogin_mysql($username, $password) {
		$mysqli = new mysqli('localhost', 'team28', 'RiddleStars', 'waph_team');

		if($mysqli->connect_errno) {
	 		printf("Database connection failed: %s\n", $mysqli->connect_error);
	 		exit();
		}

		$prepared_sql = "SELECT * FROM superusers WHERE username = ? AND password = md5(?)";
		$stmt = $mysqli->prepare($prepared_sql);
		$stmt->bind_param("ss", $username, $password);
		$stmt->execute();
		$result = $stmt->get_result();
		
		if($result->num_rows == 1) {
			return TRUE;
		}
		return FALSE;
	}
?>
<h2> Welcome <?php echo htmlentities($_SESSION['username']); ?> !</h2>
<a href="viewUsers.php">View registered users</a>
<a href="logout.php">Logout</a>