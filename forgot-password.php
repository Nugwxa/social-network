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
        <link rel="stylesheet" type="text/css" href="css/style.css">
        <title>Reset Password | Vance Social&trade;</title>
</head>
<body class="landing-body">

	<div class="login-container">
		<img src="images/Landing/Troftey_logo(Landing).png">
		<form action="forgot-password.php" method="post">
			<div class="landing-input">

				<input class="input" type="text" name="email" value="" placeholder="Email">
			
			</div>

			<input id="log-submit" type="submit" name="resetpassword" value="Reset Password">
		</form>
	</div>
</body>
</html>
