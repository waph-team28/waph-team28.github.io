<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Posts page</title>
  <link rel="stylesheet" href="posts.css">
</head>
<body>
<?php
  require "input_sanitize.php";
  require "session_auth.php";
  startSession();
  checkAuthentication();
  $rand = bin2hex(openssl_random_pseudo_bytes(16));
  $_SESSION["nocsrftoken"] = $rand;

  function showPost($postid){

    $postid = cleanInputs($postid);
    $mysqli = new mysqli('localhost', 'team28', 'RiddleStars', 'waph_team');

    if($mysqli->connect_errno) {
      printf("Database connection failed: %s\n", $mysqli->connect_error);
      exit();
    }
    
    $prepared_sql = "select postid, postOwner, postContent, timeCreated from posts where postid=?;";
    $stmt = $mysqli->prepare($prepared_sql);
    $stmt->bind_param("s", $postid);
    $success = $stmt->execute();
    if(!$success){
      echo "Cannot display your posts";
    }else{
      $stmt->bind_result($postid, $postOwner, $postContent, $timeCreated);
      while($stmt->fetch()){
        $post = array($postid, $postOwner, $postContent, $timeCreated);
      }
    }

    return $post;
  }

  
  
  
  if(isset($_POST["postid"])){
    $postid = $_POST["postid"];
    $postid = cleanInputs($postid);
  $post = showPost($postid);
    
    ?>
    <div class="post"> 
      <form action="editPost.php" method="POST">
         <input type="hidden" name="postid" value="<?php echo htmlentities($post[0]); ?>">
        
    <h2><?php echo htmlentities($post[1]) ?></h2>
    <input type="text" name="content" class="content" value="<?php echo htmlentities($post[2]) ?>">
    <input type="hidden" name="nocsrftoken" value="<?php echo $rand; ?>"/>
    <button type="submit">Save</button>
      </form>
    <span class="timestamp"><?php echo htmlentities($post[3]) ?></span>
    </div>
    

  </div>
    <?php
  }

  ?>
  

  