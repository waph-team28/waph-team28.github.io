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
  $rand = bin2hex(openssl_random_pseudo_bytes(16));
  $_SESSION["nocsrftoken"] = $rand;

  startSession();
  checkAuthentication();

  function showPosts(){
    $mysqli = new mysqli('localhost', 'team28', 'RiddleStars', 'waph_team');

    if($mysqli->connect_errno) {
      printf("Database connection failed: %s\n", $mysqli->connect_error);
      exit();
    }
    $posts = array();
    $prepared_sql = "select postid, postOwner, postContent, timeCreated from posts where postOwner=?;";
    $stmt = $mysqli->prepare($prepared_sql);
    $stmt->bind_param("s", $_SESSION["username"]);
    $success = $stmt->execute();
    if(!$success){
      echo "Cannot display your posts";
    }else{
      $stmt->bind_result($postid, $postOwner, $postContent, $timeCreated);
      while($stmt->fetch()){
        $posts[] = array($postid, $postOwner, $postContent, $timeCreated);
      }
    }

    return $posts;
  }

  function showComments($postid){
    $mysqli = new mysqli('localhost', 'team28', 'RiddleStars', 'waph_team');

    if($mysqli->connect_errno) {
      printf("Database connection failed: %s\n", $mysqli->connect_error);
      exit();
    }
    $comments = array();
    $prepared_sql = "select commentOwner, commentContent, timeCreated from comments where originalPost=?;";
    $stmt = $mysqli->prepare($prepared_sql);
    $stmt->bind_param("s", $postid);
    $success = $stmt->execute();
    if(!$success){
      echo "Cannot display comments";
    }else{
      $stmt->bind_result( $commentOwner, $commentContent, $timeCreated);
      while($stmt->fetch()){
        $comments[] = array($commentOwner, $commentContent, $timeCreated);

      }
    }

    return $comments;
  }
  
  function addNewComment($postid, $commentContent){
    $postid = cleanInputs($postid);
    $commentContent = cleanInputs($commentContent);
    $mysqli = new mysqli('localhost', 'team28', 'RiddleStars', 'waph_team');

    if($mysqli->connect_errno) {
      printf("Database connection failed: %s\n", $mysqli->connect_error);
      exit();
    }
    $prepared_sql = "INSERT INTO comments (commentOwner, originalPost, commentContent) VALUES (?,?,?);";
    $stmt = $mysqli->prepare($prepared_sql);
    $stmt->bind_param("sss", $_SESSION["username"], $postid, $commentContent);
    $stmt->execute();
    

  }
  if (isset($_POST['addComment'])) {
    $postid = $_POST['postid'];
    $commentContent = $_POST['commentContent'];
    $postid = cleanInputs($postid);
    $commentContent = cleanInputs($commentContent);
    addNewComment($postid, $commentContent);

    header("Location: {$_SERVER['PHP_SELF']}");
    exit;
  }

  $posts = showPosts();
  foreach($posts as $post){
    
    ?>
    <div class="post"> 
      <form action="editPostForm.php" method="POST">
         <input type="hidden" name="postid" value="<?php echo $post[0]; ?>">
        <button type="submit">Edit Post</button>
      </form>
      <form action="deletePost.php" method="POST">
         <input type="hidden" name="postid" value="<?php echo $post[0]; ?>">
         <input type="hidden" name="nocsrftoken" value="<?php echo $rand; ?>"/>
        <button type="submit">Delete Post</button>
      </form>
    <h2><?php echo htmlentities($post[1]) ?></h2>
    <div class="content">
    <?php echo htmlentities($post[2]) ?>
    <span class="timestamp"><?php echo htmlentities($post[3]) ?></span>
    </div>
    <?php
    $comments = showComments($post[0]);
    foreach($comments as $comment){
    ?>
     <div class="comments">
      <span class="author">
      <?php echo htmlentities($comment[0]) . ": ";?>
    </span>
      <span class="content">
      <?php echo htmlentities($comment[1]) ?>
      <span class="timestamp"><?php echo htmlentities($comment[2]) ?></span>
    </span>
    </div>
      <?php

    }

    ?>

    <form class="add-comment-form" method="post">
        <input type="hidden" name="postid" value="<?php echo $post[0]; ?>">
        <textarea name="commentContent" placeholder="Your Comment"></textarea><br>
        <input type="submit" name="addComment" value="Add Comment">
    </form>
  </div>
    <?php
  }
  ?>
  <a href="index.php">Back to main page</a>
  

  