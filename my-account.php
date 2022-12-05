<!DOCTYPE html>
<html>
<head>
        <link rel="icon" href="images/FAVICON.png" type="image/x-icon">
        <link rel="stylesheet" type="text/css" href="css/style.css">
        <title>MY ACCOUNT | Vance Social</title>
</head>
<body class="landing-body">

	<?php
include('./classes/DB.php');
include('./classes/Login.php');
if (Login::isLoggedIn()) {
        $userid = Login::isLoggedIn();
} else {
        die('Not logged in!');
}
if (isset($_POST['uploadprofileimg'])) {
        Image::uploadImage('profileimg', "UPDATE users SET profileimg = :profileimg WHERE id=:userid", array(':userid'=>$userid));
}
?>

	<div class="login-container">
		<h1 style="font-size: 30px; padding-left: 20px; padding-right: 20px; color: #E8E8E8;">Upload a profile image</h1>
		<form action="my-account.php" method="post">
			<div class="landing-input">
				<input type="file" accept="image/png, image/jpeg" name="profileimg">
			</div>

			<input id="log-submit" type="submit" name="uploadprofileimg" value="Upload Image">
		</form>
	</div>
</body>
</html>
