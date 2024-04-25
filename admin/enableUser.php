<?php
	$lifetime = 15*60;
    $path = "/";
    $domain = "192.167.9.238";
    $secure = TRUE;
    $httponly = TRUE;
    session_set_cookie_params($lifetime, $path, $domain, $secure, $httponly);
	session_start();  
	

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
    
	

  	function enableUser($username){
        $mysqli = new mysqli('localhost', 'team28', 'RiddleStars', 'waph_team');

    if($mysqli->connect_errno) {
      printf("Database connection failed: %s\n", $mysqli->connect_error);
      exit();
    }

    $prepared_sql = "UPDATE users set role=true where username=?";

    $stmt = $mysqli->prepare($prepared_sql);
    $stmt->bind_param("s", $username);
    $success = $stmt->execute();
    
    
    if($success){
      echo "User enabled succesfully";
    }else{
      echo "Unable to enable user";
    }
    
    
    
  }
  
  $username = $_POST["username"];
  enableUser($username);
?>
<a href="viewUsers.php">View users</a>