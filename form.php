
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>WAPH-Login page</title>
  <link rel="stylesheet" href="css/registrationform.css">
  <link href="https://fonts.googleapis.com/css?family=Ubuntu" rel="stylesheet">
</head>
<body>
  <div class="main_login">
    <p class="sign" align="center">Welcome to Mini Facebook! Please Login</p>
    <form class="form1" action="index.php" method="POST" class="form login">
       <input  type="text" class="un " name="username" placeholder="Username" required  
              pattern="\w+" 
              title="Please enter a valid username"
              onchange="this.setCustomValidity(this.validity.patternMismatch?this.title:'');"/><br>
      <input type="password" class="pass" name="password" placeholder="Password"/> <br>
      <button class="submit" type="submit">Login</button><br>
      <div class="reg">New User? Register <a href="/userRegistrationForm.php">here</a></div>
      <div class="reg">Admin Login <a href="/admin/loginform.php">here</a></div>
    </form>
  </div>
</body>
</html>
