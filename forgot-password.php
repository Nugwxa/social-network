<?php
include('./classes/DB.php');
if (isset($_POST['resetpassword'])) {
        $cstrong = True;
        $token = bin2hex(openssl_random_pseudo_bytes(64, $cstrong));
        $email = $_POST['email'];
        $user_id = DB::query('SELECT id FROM users WHERE email=:email', array(':email'=>$email))[0]['id'];
        DB::query('INSERT INTO password_tokens VALUES (\'\', :token, :user_id)', array(':token'=>sha1($token), ':user_id'=>$user_id));
        echo 'Email sent!';
        echo '<br />';
        echo $token;
}
?>
<!DOCTYPE html>
<html>
<head>
        <link rel="icon" href="images/FAVICON.png" type="image/x-icon">
        <title>Reset Password | Vance Social</title>
        <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
<section id="nav3">
                <div>
  <ul>
    <li><a href="index.php"><span>DISO</span></a></li>
  </ul>
</div>
</section>

<section id="rest">
<h1>Reset Password</h1>
<form action="forgot-password.php" method="post">
        <input id="eail" type="text" name="email" value="" placeholder="Email"><br>
        <input id="restp" type="submit" name="resetpassword" value="Reset Password">
</form>
</section>
</body>
</html>
