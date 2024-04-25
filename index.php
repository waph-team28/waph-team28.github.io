<?php

    require "input_sanitize.php";
    require "session_auth.php";
	
	startSession();
	if(isset($_POST["username"]) && isset($_POST["password"])) {

		if (checklogin_mysql($_POST["username"], $_POST["password"])) {
			$_SESSION["authenticated"] = TRUE;
			$_SESSION["username"] = $_POST['username'];
			$_SESSION["browser"] = $_SERVER["HTTP_USER_AGENT"];
		} else {
			session_destroy();
			echo "<script>alert('Invalid username or password');window.location='form.php';</script>";
			die();
		}
	}
	checkAuthentication();

	
	

  	function checklogin_mysql($username, $password) {

  		$username = cleanInputs($username);
  		$password = cleanInputs($password);

		$mysqli = new mysqli('localhost', 'team28', 'RiddleStars', 'waph_team');

		if($mysqli->connect_errno) {
	 		printf("Database connection failed: %s\n", $mysqli->connect_error);
	 		exit();
		}

        if (!preg_match("/\w+/", $username)){
        	?>
    <h2> Invalid inputs. Please go back to <a href="form.php">Login form</a></h2>
    <?php
        }
		$prepared_sql = "SELECT * FROM users WHERE username = ? AND password = md5(?)";
		$stmt = $mysqli->prepare($prepared_sql);
		$stmt->bind_param("ss", $username, $password);
		$stmt->execute();
		$result = $stmt->get_result();
		
		if($result->num_rows == 1) {
            $prepared_sql = "SELECT role FROM users WHERE username = ?";
		    $stmt = $mysqli->prepare($prepared_sql);
		    $stmt->bind_param("s", $username);
		    $stmt->execute();
		    $stmt->bind_result($role);
		    $stmt->fetch();

            if(!$role){
            	return FALSE;
            }
			return TRUE;
		}
		return FALSE;
	}
?>
<h2> Welcome <?php echo htmlentities($_SESSION['username']); ?> !</h2>
<button onclick="showHidePostArea()">Create new post</button>
<div id="postArea" style="display: none;">
	<form action="createPost.php" method="POST" class="form">
		<textarea id="textInput" name="postContent"></textarea><br>
        <button class="button" type="submit">Post</button>
    
    </form>
	
	<button onclick="window.location='/createPost.php';">Post</button>
</div><br>

<a href="/updateDetails.php">Update your details </a><br>
<a href="/changePassword.php">Change password </a><br>
<a href="/showPosts.php">Show Posts</a><br>
<a href="/showMyPosts.php">My Posts</a><br>



<a href="logout.php">Logout</a>
<script>
	function showHidePostArea(){
         let postArea = document.getElementById("postArea");
         if(postArea.style.display == "none"){
         	postArea.style.display = "block";
         }
         else{
         	postArea.style.display = "none";
         }
	}
</script>