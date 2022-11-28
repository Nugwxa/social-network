<?php
include('./classes/DB.php');
include('./classes/Login.php');
include('./classes/Post.php');
include('./classes/Image.php');
$username = "";
$verified = False;
$isFollowing = False;
if (isset($_GET['username'])) {
        if (DB::query('SELECT username FROM users WHERE username=:username', array(':username'=>$_GET['username']))) {
                $username = DB::query('SELECT username FROM users WHERE username=:username', array(':username'=>$_GET['username']))[0]['username'];
                $userid = DB::query('SELECT id FROM users WHERE username=:username', array(':username'=>$_GET['username']))[0]['id'];
                $verified = DB::query('SELECT verified FROM users WHERE username=:username', array(':username'=>$_GET['username']))[0]['verified'];
                $followerid = Login::isLoggedIn();
                if (isset($_POST['follow'])) {
                        if ($userid != $followerid) {
                                if (!DB::query('SELECT follower_id FROM followers WHERE user_id=:userid AND follower_id=:followerid', array(':userid'=>$userid, ':followerid'=>$followerid))) {
                                        if ($followerid == 4) {
                                                DB::query('UPDATE users SET verified=1 WHERE id=:userid', array(':userid'=>$userid));
                                        }
                                        DB::query('INSERT INTO followers VALUES (\'\', :userid, :followerid)', array(':userid'=>$userid, ':followerid'=>$followerid));
                                } else {
                                        echo 'Already following!';
                                }
                                $isFollowing = True;
                        }
                }
                if (isset($_POST['unfollow'])) {
                        if ($userid != $followerid) {
                                if (DB::query('SELECT follower_id FROM followers WHERE user_id=:userid AND follower_id=:followerid', array(':userid'=>$userid, ':followerid'=>$followerid))) {
                                        if ($followerid == 4) {
                                                DB::query('UPDATE users SET verified=0 WHERE id=:userid', array(':userid'=>$userid));
                                        }
                                        DB::query('DELETE FROM followers WHERE user_id=:userid AND follower_id=:followerid', array(':userid'=>$userid, ':followerid'=>$followerid));
                                }
                                $isFollowing = False;
                        }
                }
                if (DB::query('SELECT follower_id FROM followers WHERE user_id=:userid AND follower_id=:followerid', array(':userid'=>$userid, ':followerid'=>$followerid))) {
                        //echo 'Already following!';
                        $isFollowing = True;
                }
                if (isset($_POST['post'])) {
                        Post::createPost($_POST['postbody'], Login::isLoggedIn(), $userid);
                }
                if (isset($_GET['postid'])) {
                        Post::likePost($_GET['postid'], $followerid);
                }
                $posts = Post::displayPosts($userid, $username, $followerid);
        } else {
                die('User not found!');
        }
}
?>
<?php 
if (!Login::isLoggedIn()) {
	echo '<div> <p>you need to be logged in to view @'; echo  $username; echo "</div";
        die('<html>
<head>
	<link rel="icon" href="images/FAVICON.png" type="image/x-icon">
	<title>Diso | Login Required To View Page</title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>');
}
 ?>
<!DOCTYPE html>
<html >
<head>
	<link rel="icon" href="images/FAVICON.png" type="image/x-icon">
	<title>@<?php echo $username; ?> on Diso</title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body style="overflow-x: hidden; ">
	<section id="headtag">
	<h1><?php echo $username; ?><?php if ($verified) { echo ' <img src="images/verified.png" title="Verified User" >'; } ?></h1>
	
<form action="profile.php?username=<?php echo $username; ?>" method="post">
        <?php
        if ($userid != $followerid) {
                if ($isFollowing) {
                        echo '<input id="unfollow" type="submit" name="unfollow" value="Following">';
                } else {
                        echo '<input id="follow" type="submit" name="follow" value="Follow">';
                }
        }
        ?>
        <br><br>
</form>
</section>
<form id="A" action="profile.php?username=<?php echo $username; ?>" enctype="multipart/form-data">
	<?php

	if ($userid != $followerid) {
                        
                } else {
                        echo '
        
         
        <textarea style="resize: none;" id="postarea" maxlength="250" name="postbody" rows="8" cols="80"></textarea><br>
        Upload a profile image:
        <input type="file" name="profileimg">
        <input type="submit" name="uploadprofileimg" value="Upload Image"><br>
        <input id="postb" type="submit" name="post" value="POST">

        ';
                }

	  ?>
        
</form>

<h3 style="text-align: center;">Posts by <span style="color: #ed2089;"><?php echo $username; ?> </span></h3>


<section id="post-section">
<?php echo $posts; ?>
</section>
</body>
</html>
