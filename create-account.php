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
        <link rel="icon" href="images/FAVICON.png" type="image/x-icon">
        <title>Sign Up | Vance Social&trade;</title>
        <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>

<h1 style="color: white; text-align: center; font-size: 70px; font-family: Roboto;"><img id="headlogo" src="images/disologo.png" alt="ABBA" ></h1>
<h1 id="Jointhenetwork" style="color: #e9a068 ; text-align: center; font-family: Roboto; margin-top: -4%;">Join the Network</h1>
<form id="foorm" action="create-account.php" method="post">
<input id="inpuut" style="color: white; font-family: arial;" required="true" type="text" name="username" value="" placeholder="Username"><p />
<input id="inpuut" style="color: white; font-family: arial;" required="true" type="password" name="password" value="" placeholder="Password"><p />
<input id="inpuut" style="color: white; font-family: arial;" required="true" type="email" name="email" value="" placeholder="Email"><p />
<input id="buton" type="submit" name="createaccount" value="Join">
</form>

<p id="tarms" >By clicking 'Join' you agree to our <a target="_blank" style="color: #e89d63; text-decoration: none;" href="#">Policies</a></p>

<p style=" text-align: center; color: #4daea5;">Existing User ? <a style="color: #e89d63; text-decoration: none;" href="login.php">Sign In</a> </p>

</body>
</html>
