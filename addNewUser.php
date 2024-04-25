<?php
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    require "input_sanitize.php";

    function createNewUser($username, $password, $name, $phone, $email, $additionalEmail) {

        $username = cleanInputs($username);
        $password = cleanInputs($password);
        $name = cleanInputs($name);
        $phone = cleanInputs($phone);
        $email = cleanInputs($email);
        $additionalEmail = cleanInputs($additionalEmail);

        if (!preg_match("/\w+/", $username) || 
            !preg_match("/^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#$%^&])[\w!@#$%^&]{8,}$/s", $password) || 
            !preg_match("/[^\s@]+@[^\s@]+\.[^\s@]+/", $email) || 
            !preg_match("/[^\s@]+@[^\s@]+\.[^\s@]+/", $additionalEmail) || 
            !preg_match("/[0-9]{3}-[0-9]{3}-[0-9]{4}/", $phone)) {
?>
    <h2> Invalid inputs. Please go back to <a href="userRegistrationForm.php">registration form</a></h2>
<?php
        } else {

            $mysqli = new mysqli('localhost', 'team28', 'RiddleStars', 'waph_team');

            if($mysqli->connect_errno) {
                printf("Database connection failed: %s\n", $mysqli->connect_error);
                exit();
            }
            $prepared_sql = "INSERT INTO users(username, password, name, phone, email, additionalEmail) VALUES(?, md5(?), ?, ?, ?, ?);";
            $stmt = $mysqli->prepare($prepared_sql);
            $stmt->bind_param("ssssss", $username, $password, $name, $phone, $email, $additionalEmail);
            $success = $stmt->execute();
            
            if($success) {
?>
                <h2> You are successfully registered! </h2>
                <a href="/form.php">Login here</a>
<?php
            } else {
?>
                <h2> Cannot register</h2>
<?php
            }
        }
    }

    if(isset($_POST["username"]) && isset($_POST["password"]) && isset($_POST["name"]) && isset($_POST["phone"]) && isset($_POST["email"]) && isset($_POST["additionalEmail"])) {

        $username = cleanInputs($_POST["username"]);
        $password = cleanInputs($_POST["password"]);
        $name = cleanInputs($_POST["name"]);
        $phone = cleanInputs($_POST["phone"]);
        $email = cleanInputs($_POST["email"]);
        $additionalEmail = cleanInputs($_POST["additionalEmail"]);

        if (!preg_match("/\w+/", $username) || 
            !preg_match("/^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#$%^&])[\w!@#$%^&]{8,}$/s", $password) || 
            !preg_match("/[^\s@]+@[^\s@]+\.[^\s@]+/", $email) || 
            !preg_match("/[^\s@]+@[^\s@]+\.[^\s@]+/", $additionalEmail) || 
            !preg_match("/[0-9]{3}-[0-9]{3}-[0-9]{4}/", $phone)) {
?>
                <h2> Invalid inputs. Please go back to <a href="userRegistrationForm.php">registration form</a></h2>
<?php
        } else {
            createNewUser($_POST["username"], $_POST["password"], $_POST["name"], $_POST["phone"], $_POST["email"], $_POST["additionalEmail"]);
        }
    } else {
?>
    <h2> Invalid inputs. Please go back to <a href="userRegistrationForm.php">registration form</a></h2>
<?php
    }
?>
