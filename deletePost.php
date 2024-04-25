<?php

  require "input_sanitize.php";
  require "session_auth.php";
  startSession();
  checkAuthentication();
   $token = $_POST["nocsrftoken"];
   echo $token;
   echo $_SESSION["nocsrftoken"];
  if (!isset($token) or ($token!=$_SESSION["nocsrftoken"])){

  echo "CSRF Attack is detected";
  die();
  }

  function deletePost($postid){
    $postid = cleanInputs($postid);
  	$mysqli = new mysqli('localhost', 'team28', 'RiddleStars', 'waph_team');

    if($mysqli->connect_errno) {
      printf("Database connection failed: %s\n", $mysqli->connect_error);
      exit();
    }
    $prepared_sql = "DELETE from posts where postid=?";
    $stmt = $mysqli->prepare($prepared_sql);
    $stmt->bind_param("s", $postid);
    $success = $stmt->execute();
    if(!$success){
    	return false;
    }
    return true;
  }
  if(isset($_POST["postid"])){
  $postid = $_POST["postid"];
  if(deletePost($postid)){
  	echo "Delete successful";
  }else{
  	echo "Delete failed";
  }
}
  ?>
  <a href="showMyPosts.php">Back to your posts</a>