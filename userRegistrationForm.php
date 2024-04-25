
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>WAPH-Login page</title>
  <link rel="stylesheet" href="registrationform.css">
  <link href="https://fonts.googleapis.com/css?family=Ubuntu" rel="stylesheet">
  
</head>
<body>
  <div class="main">
    <p class="sign" align="center">Register</p>
    <form id="form" class="form1" action="addNewUser.php" method="POST" >
      <input  type="text" class="un " name="username" placeholder="Username" required  
              pattern="\w+" 
              title="Please enter a valid username"
              onchange="this.setCustomValidity(this.validity.patternMismatch?this.title:'');"/><br>
      <input type="text" class="un " name="name" placeholder="Full Name" required> <br>
      <input type="text" class="un " name="email" placeholder="Email" required
            pattern="[^\s@]+@[^\s@]+\.[^\s@]+" 
              title="Please enter a valid email"
              onchange="this.setCustomValidity(this.validity.patternMismatch?this.title:'');"/><br>
      <input id="password" type="password" class="pass" name="password" placeholder="Password" required
            pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#$%^&])[\w!@#$%^&]{8,}$"
            title="Password must have at least 8 characters with 1 special symbol !@#$%^& 1 number, 1
            lowercase, and 1 UPPERCASE"
            /> <br>
      
     <input type="tel" class="un" name="phone" placeholder="Phone number" required
       pattern="[0-9]{3}-[0-9]{3}-[0-9]{4}" 
       title="Please enter a valid phone number in the format XXX-XXX-XXXX"
       onchange="this.setCustomValidity(this.validity.patternMismatch ? this.title : '');"/><br>
     <input type="text" class="un " name="additionalEmail" placeholder="Additional Email" required
            pattern="[^\s@]+@[^\s@]+\.[^\s@]+" 
              title="Please enter a valid email"
              onchange="this.setCustomValidity(this.validity.patternMismatch?this.title:'');"/><br>
      <button class="submit" type="submit">Register</button>
      <div class="reg">Already registered? Click <a href="/form.php">here</a> to login</div>
    </form>
  </div>
</body>
</html>