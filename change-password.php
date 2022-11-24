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
        <link rel="stylesheet" type="text/css" href="style.css">
        <title>Change Password | Vance Social</title>
</head>
<body style="overflow: hidden;">
        <section id="nav">
                <div>
  <ul>
    <li><a class="nava" href="#">Home</a></li>
    <li><a class="nava" href="#">Notifications</a></li>
    <li><a class="nava" href="#">Messages</a></li>
    <li><input type="text" placeholder="Search Diso" name=""></li>
    <li><div class="dropdown"><button class="dropbtn">User</button>
          <div class="dropdown-content">
    <a href="my-account.php">My Account</a>
    <a href="logout.php">Logout</a>
  </div>
    </div></li>
  </ul>
</div>
        </section>
        <div id="change">
                        
        <h1>Change your Password</h1>


<form id="d87594" action="<?php if (!$tokenIsValid) { echo 'change-password.php'; } else { echo 'change-password.php?token='.$token.''; } ?>" method="post">
        <?php if (!$tokenIsValid) { echo '<input id="q619" type="password" name="oldpassword" value="" placeholder="Current Password"><p />'; } ?>
        <input id="q619" type="password" name="newpassword" value="" placeholder="New Password"><p />
        <input id="q619" type="password" name="newpasswordrepeat" value="" placeholder="Repeat New Password"><p />
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
        ?><br>
        <input  class="lol" type="submit" name="changepassword" value="Change Password">
</form>
</div>
</body>
</html>