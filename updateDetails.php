<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>WAPH-Update page</title>
</head>
<?php
       require "session_auth.php";
       startSession();
       checkAuthentication();
       $rand = bin2hex(openssl_random_pseudo_bytes(16));
       $_SESSION["nocsrftoken"] = $rand;
?>
<body>
  <h1>Please update your details here</h1>

  <form action="updateUser.php" method="POST" class="form login">
     <input type="text" class="text_field" name="name" placeholder="Name" /> <br>
     <input type="tel" class="un" name="phone" placeholder="Phone number" required
       pattern="[0-9]{3}-[0-9]{3}-[0-9]{4}" 
       title="Please enter a valid phone number in the format XXX-XXX-XXXX"
       onchange="this.setCustomValidity(this.validity.patternMismatch ? this.title : '');"/><br>
       <input type="text" class="un " name="email" placeholder="Email" required
            pattern="[^\s@]+@[^\s@]+\.[^\s@]+" 
              title="Please enter a valid email"
              onchange="this.setCustomValidity(this.validity.patternMismatch?this.title:'');"/><br>
     <input type="text" class="un " name="additionalEmail" placeholder="Additional Email" required
            pattern="[^\s@]+@[^\s@]+\.[^\s@]+" 
              title="Please enter a valid email"
              onchange="this.setCustomValidity(this.validity.patternMismatch?this.title:'');"/><br>
      <input type="hidden" name="nocsrftoken" value="<?php echo $rand; ?>"/>
    <button class="button" type="submit">Update</button>
    
  </form>
  
</body>
</html>
