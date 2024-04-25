<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>WAPH-Change password page</title>
</head>
<?php
         require "session_auth.php";
         startSession();
       checkAuthentication();
       $rand = bin2hex(openssl_random_pseudo_bytes(16));
       $_SESSION["nocsrftoken"] = $rand;
?>
<body>
  <h1>Change your password here:</h1>

  <form action="updatePassword.php" method="POST" class="form login">
     <input id="password" type="password" class="pass" name="password" placeholder="Password" required placeholder="New password" 
            pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#$%^&])[\w!@#$%^&]{8,}$"
            title="Password must have at least 8 characters with 1 special symbol !@#$%^& 1 number, 1
            lowercase, and 1 UPPERCASE"
            /> <br>
            <input type="hidden" name="nocsrftoken" value="<?php echo $rand; ?>"/>
    <button class="button" type="submit">Update</button>
    
  </form>
  
</body>
</html>
