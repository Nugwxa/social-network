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
<body>



        <img class="wave" src="images/wave.png">

        <div class="container">
                <div class="img">
                        <img src="images/illustrations/home.png">
                </div>
                <div class="login-container">
                        <form action="login.php" method="post">
                                <img class="avatar" src="images/illustrations/male_avatar.svg">
                                <h2>Welcome</h2>
                                <div class="input-div">
                                        <div class="i">
                                                <i class="fas fa-user"></i>
                                        </div>
                                        <div>
                                                <h5>Username</h5>
                                                <input class="input"  type="text" name="username" value="" >
                                        </div>
                                </div>

                                <div class="input-div">
                                        <div class="i">
                                                <i class="fas fa-lock"></i>
                                        </div>
                                        <div>
                                                <h5>Password</h5>
                                                <input class="input" type="password" name="password" value="" >
                                        </div>
                                </div>
                                <a id="signup" href="forgot-password.php">Sign up</a>

                                <a id="forgot" href="forgot-password.php">Forgot Password?</a>                                
                                
                                <input type="submit" class="btn" name="login" value="Login">
                        </form>
                </div>
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
