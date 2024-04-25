<?php
      function startSession(){
        $lifetime = 15*60;
        $path = "/";
        $domain = "192.167.9.238";
        $secure = TRUE;
        $httponly = TRUE;
        session_set_cookie_params($lifetime, $path, $domain, $secure, $httponly);
  session_start(); 
}

  function checkAuthentication(){
  if (!$_SESSION["authenticated"] or $_SESSION["authenticated"]!=TRUE){
     session_destroy();
     echo "<script> alert('You have not logged in. Please make sure to log in first');</script>";
     header("Refresh:0; url=loginform.php");
     die();
  }
  
  if ($_SESSION["browser"] != $_SERVER["HTTP_USER_AGENT"]){
     echo "<script> alert('Session hijacking detected!');</script>";
     header("Refresh:0; url=loginform.php");
     die();
  }
}

?>