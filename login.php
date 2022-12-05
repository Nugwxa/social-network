<?php
include('classes/DB.php');
include('classes/Login.php');

if (Login::isLoggedIn()) {
        header('Location: '.'index.php');
}

?>

<!DOCTYPE html>
<html style="overflow-x: hidden;">
<head>
        <meta name="viewport" content="width=device-width, initial-scale=1" >
        <link rel="icon" href="images/FAVICON.png" type="image/x-icon">
        <link rel="stylesheet" type="text/css" href="css/style.css">
        <title>Login | Vance Social&trade;</title>
        <script src="https://kit.fontawesome.com/a81368914c.js" crossorigin="anonymous"></script>

</head>
<body class="landing-body">

        <div class="login-container">
			<img src="images/Landing/Troftey_logo(Landing).png">
			<form action="login.php" method="post">

				<div class="landing-input">
                                        <input placeholder="Username" class="input"  type="text" name="username" value="" >
                                </div>
				
				<div class="landing-input">
                                        <input placeholder="Password" class="input" type="password" name="password" value="" >
                                </div>
				
				<div class="log-text">
					<a href="forgot-password.php">Forgot Password?</a><br>
					<a href="create-account.php">Sign Up</a><br>
				</div>                    
                                
                <input id="log-submit" type="submit" class="btn" name="login" value="LOG IN">
			</form>
        </div>

                
<?php

if (isset($_POST['login'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];
        if (DB::query('SELECT username FROM users WHERE username=:username', array(':username'=>$username))) {
                if (password_verify($password, DB::query('SELECT password FROM users WHERE username=:username', array(':username'=>$username))[0]['password'])) {
                        header('Location: '.'profile.php?username=Troftey');
                        echo ' <p id="eko">Logged in</p>';
                        $cstrong = True;
                        $token = bin2hex(openssl_random_pseudo_bytes(64, $cstrong));
                        $user_id = DB::query('SELECT id FROM users WHERE username=:username', array(':username'=>$username))[0]['id'];
                        DB::query('INSERT INTO login_tokens VALUES (\'\', :token, :user_id)', array(':token'=>sha1($token), ':user_id'=>$user_id));
                        setcookie("SNID", $token, time() + 60 * 60 * 24 * 7, '/', NULL, NULL, TRUE);
                        setcookie("SNID_", '1', time() + 60 * 60 * 24 * 3, '/', NULL, NULL, TRUE);
                } else {
                        echo ' <p id="eko">Incorrect Password</p>';
                }
        } else {
                echo ' <p id="eko">Incorrect Username or Password</p>';
        }
}

?>


<script type="text/javascript" src="js/main.js"></script>
</body>
</html>
