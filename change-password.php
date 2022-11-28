<?php
include('./classes/DB.php');
include('./classes/Login.php');
$tokenIsValid = False;
if (!Login::isLoggedIn()) {
        header('Location: '.'index.php');
}

?>
<!DOCTYPE html>
<html>
<head>
        <link rel="icon" href="images/FAVICON.png" type="image/x-icon">
        <link rel="stylesheet" type="text/css" href="css/style.css">
        <title>Change Password | Vance Social</title>
</head>
<body class="landing-body">

	<div class="login-container">
		<h1 style="font-size: 30px; padding-left: 20px; padding-right: 20px; color: #E8E8E8;">Change Password</h1>
		<form action="<?php if (!$tokenIsValid) { echo 'change-password.php'; } else { echo 'change-password.php?token='.$token.''; } ?>" method="post">
                <?php if (!$tokenIsValid) { echo '
                        <div class="landing-input">
				<input required="true"  type="password" name="oldpassword" value="" placeholder="Current Password">
			</div>
                        '; } ?>
                        
                        <div class="landing-input">
				<input required="true" type="password" name="newpassword" value="" placeholder="New Password">
			</div>

			<div class="landing-input">
				<input required="true" type="password" type="password" name="newpasswordrepeat" value="" placeholder="Repeat New Password">
			</div>
                        <?php 
                        if (Login::isLoggedIn()) {
                                if (isset($_POST['changepassword'])) {
                                        $oldpassword = $_POST['oldpassword'];
                                        $newpassword = $_POST['newpassword'];
                                        $newpasswordrepeat = $_POST['newpasswordrepeat'];
                                        $userid = Login::isLoggedIn();
                                        if (password_verify($oldpassword, DB::query('SELECT password FROM users WHERE id=:userid', array(':userid'=>$userid))[0]['password'])) {
                                                if ($newpassword == $newpasswordrepeat) {
                                                        if (strlen($newpassword) >= 6 && strlen($newpassword) <= 60) {
                                                                DB::query('UPDATE users SET password=:newpassword WHERE id=:userid', array(':newpassword'=>password_hash($newpassword, PASSWORD_BCRYPT), ':userid'=>$userid));
                                                                echo '<p class="veo">Password changed successfully!';
                                                        }
                                                } else {
                                                        echo ' <p class="veo">Passwords dont match</p>';
                                                }
                                        } else {
                                                echo ' <p class="veo">INCORRECT OLD PASSWORD</p>';
                                        }
                                }
                        } else {
                                if (isset($_GET['token'])) {
                                        $token = $_GET['token'];
                                        if (DB::query('SELECT user_id FROM password_tokens WHERE token=:token', array(':token'=>sha1($token)))) {
                                                $userid = DB::query('SELECT user_id FROM password_tokens WHERE token=:token', array(':token'=>sha1($token)))[0]['user_id'];
                                                $tokenIsValid = True;
                                                if (isset($_POST['changepassword'])) {
                                                        $newpassword = $_POST['newpassword'];
                                                        $newpasswordrepeat = $_POST['newpasswordrepeat'];
                                                        if ($newpassword == $newpasswordrepeat) {
                                                                if (strlen($newpassword) >= 6 && strlen($newpassword) <= 60) {
                                                                        DB::query('UPDATE users SET password=:newpassword WHERE id=:userid', array(':newpassword'=>password_hash($newpassword, PASSWORD_BCRYPT), ':userid'=>$userid));
                                                                        echo '<p class="veo">Password changed successfully!</p>';
                                                                        DB::query('DELETE FROM password_tokens WHERE user_id=:userid', array(':userid'=>$userid));
                                                                }
                                                        } else {
                                                                echo ' <p class="veo">Passwords dont match</p>';
                                                        }
                                                }
                                        } else {
                                                die('Token invalid');
                                        }
                                } else {
                                        die('Not logged in');
                                }
                        }
                        ?>
        <input id="log-submit" type="submit" name="changepassword" value="Change Password">
		</form>
        </div>
</body>
</html>
