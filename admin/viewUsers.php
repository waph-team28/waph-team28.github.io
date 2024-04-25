<a href="index.php">Home</a>
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
    
	

  	function viewUsers(){
        $mysqli = new mysqli('localhost', 'team28', 'RiddleStars', 'waph_team');

    if($mysqli->connect_errno) {
      printf("Database connection failed: %s\n", $mysqli->connect_error);
      exit();
    }

    $prepared_sql = "select username, role from users;";
    $stmt = $mysqli->prepare($prepared_sql);
    $success = $stmt->execute();
    
    
    if($success){
      ?>
      <h2> List of users: </h2>
      <?php
      $stmt->bind_result($username, $role);
      while($stmt->fetch()){
        echo(htmlentities($username));
        ?>
        <form action="disableUser.php" method="POST"> 
        	<input type="hidden" name="username" value="<?php echo $username; ?>">
        	<button value="submit"<?php if(!$role) echo 'disabled'?>>Disable</button>
        </form>
        <form action="enableUser.php" method="POST"> 
        	<input type="hidden" name="username" value="<?php echo $username; ?>">
        	<button value="submit" <?php if($role) echo 'disabled'?>>Enable</button>
        </form>
        <hr>
        <?php
      }
    }else{
      ?>
      <h2> Cannot display users</h2>
      <a href="/index.php">Home</a>
      <?php
    }
    
    
    
  }

  viewUsers();
?>
