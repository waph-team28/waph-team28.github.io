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
  function editPost($postid, $content){

  	$postid = cleanInputs($postid);
  	$content = cleanInputs($content);
  	$mysqli = new mysqli('localhost', 'team28', 'RiddleStars', 'waph_team');

    if($mysqli->connect_errno) {
      printf("Database connection failed: %s\n", $mysqli->connect_error);
      exit();
    }
    $prepared_sql = "UPDATE posts SET postContent=? where postid=?";
    $stmt = $mysqli->prepare($prepared_sql);
    $stmt->bind_param("ss", $content, $postid);
    $success = $stmt->execute();
    if(!$success){
    	return false;
    }
    return true;
  }
  if(isset($_POST["postid"]) && $_POST["content"]){
  $postid = cleanInputs($_POST["postid"]);
  $content = cleanInputs($_POST["content"]);
  if(editPost($postid, $content)){
  	echo "Update successful";
  }else{
  	echo "Update failed";
  }
}else{
  ?>
  <h2> Invalid inputs </h2>
  <?php
}
  ?>

  <a href="showMyPosts.php">Back to your posts</a>