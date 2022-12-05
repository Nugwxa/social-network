<?php
include('./classes/DB.php');
include('./classes/Login.php');
if (!Login::isLoggedIn()) {
        header('Location: '.'index.php');
}
if (isset($_POST['confirm'])) {
        if (isset($_POST['alldevices'])) {
                DB::query('DELETE FROM login_tokens WHERE user_id=:userid', array(':userid'=>Login::isLoggedIn()));
        } else {
                if (isset($_COOKIE['SNID'])) {
                        DB::query('DELETE FROM login_tokens WHERE token=:token', array(':token'=>sha1($_COOKIE['SNID'])));
                }
                setcookie('SNID', '1', time()-3600);
                setcookie('SNID_', '1', time()-3600);
        }
}
?>

<!DOCTYPE html>
<html>
<head>
        <link rel="icon" href="images/FAVICON.png" type="image/x-icon">
        <link rel="stylesheet" type="text/css" href="css/style.css">
        <title>Logout | Vance Social&trade;</title>
</head>
<body class="landing-body">

	<div class="login-container">
		<img src="images/Landing/Troftey_logo(Landing).png">
		<form action="logout.php" method="post">
			<div class="logout-input">
				
				<input id="logout-checkbox" type="checkbox" name="alldevices" value="alldevices"> <label for="logout-checkbox">Logout of all devices</label>
				
			</div>

			<input id="log-submit" type="submit" name="confirm" value="Logout">
		</form>
	</div>
</body>
</html>


