<?php
include('classes/DB.php');
include('classes/Login.php');

if (Login::isLoggedIn()) {
        header('Location: '.'profile.php?username=diso');
}
if (isset($_POST['createaccount'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];
        $email = $_POST['email'];
        if (!DB::query('SELECT username FROM users WHERE username=:username', array(':username'=>$username))) {
                if (strlen($username) >= 3 && strlen($username) <= 32) {
                        if (preg_match('/[a-zA-Z0-9_]+/', $username)) {
                                if (strlen($password) >= 6 && strlen($password) <= 60) {
                                if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                                        DB::query('INSERT INTO users VALUES (\'\', :username, :password, :email, \'0\', \'\')', array(':username'=>$username, ':password'=>password_hash($password, PASSWORD_BCRYPT), ':email'=>$email));

                                        header('Location: '.'login.php');
                                        
                                        echo ' <p id="eko2">Succes</p>';
                                } else {
                                        echo ' <p id="eko2">Invalid Email</p>';
                                }
                        } else {
                                echo ' <p id="eko2">Invalid Password</p>';
                        }
                        } else {
                                echo ' <p id="eko">Invalid Username</p>';
                        }
                } else {
                        echo ' <p id="eko2">Invalid Username</p>';
                }
        } else {
                echo ' <p id="eko2">User already registered</p>';
        }
}
?>
<!DOCTYPE html>
<html style="overflow-x: hidden;">
<head>
        <meta name="viewport" content="width=device-width, initial-scale=1" >
        <link rel="icon" href="images/FAVICON.png" type="image/x-icon">
        <link rel="stylesheet" type="text/css" href="css/style.css">
        <title>Sign Up | Vance Social&trade;</title>
        <script src="https://kit.fontawesome.com/a81368914c.js" crossorigin="anonymous"></script>

</head>
<body class="landing-body">
        <div class="login-container">
                <img src="images/Landing/Troftey_logo(Landing).png">
                <form action="create-account.php" method="post"> 
                        <div class="landing-input">
                                <input style="color: white; font-family: arial;" required="true" type="text" name="username" value="" placeholder="Username">
                        </div>

                        <div class="landing-input">
                                <input style="color: white; font-family: arial;" required="true" type="password" name="password" value="" placeholder="Password">
                        </div>

                        <div class="landing-input">
                                <input style="color: white; font-family: arial;" required="true" type="email" name="email" value="" placeholder="Email">
                        </div>

                        <div class="log-text">
					<a href="login.php">Log in</a><br>
					<a>By clicking 'Join' you agree to our <a target="_blank" style="color: #D15A87; text-decoration: none;" href="#">Policies</a></a><br>
				</div>           

                        <input id="log-submit" type="submit" name="createaccount" value="Join">
                </form>
        </div>
</body>
</html>
