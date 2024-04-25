<?php
require "input_sanitize.php";
       require "session_auth.php";
  startSession();
       checkAuthentication();


  function createPost($postContent){
        $postContent = cleanInputs($postContent);
        $mysqli = new mysqli('localhost', 'team28', 'RiddleStars', 'waph_team');

    if($mysqli->connect_errno) {
      printf("Database connection failed: %s\n", $mysqli->connect_error);
      exit();
    }

    $prepared_sql = "INSERT INTO posts(postOwner, postContent) VALUES (?, ?)";
    $stmt = $mysqli->prepare($prepared_sql);
    $stmt->bind_param("ss", $_SESSION["username"], $postContent);
    $success = $stmt->execute();
    
    
    if($success){
      ?>
      <h2> Successfully posted! </h2>
      <a href="/index.php">Home</a>
      <?php

    }else{
      ?>
      <h2> Cannot post</h2>
      <a href="/index.php">Home</a>
      <?php
    }
    
    
    
  }
  
  
  if(isset($_POST["postContent"])) {

        
        $postContent = cleanInputs($_POST["postContent"]);
        createPost($_POST["postContent"]);
        
    } else {
?>
    <h2> Invalid inputs. Please go back to <a href="changePassword.php">password change form</a></h2>
<?php
    }
?>
