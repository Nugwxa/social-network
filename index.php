<?php
include('./classes/DB.php');
include('./classes/Login.php');
include('./classes/Post.php');
include('./classes/Comment.php');
include('./classes/Follower.php');
?>

<?php
if (!Login::isLoggedIn()) {
	die('
<!DOCTYPE html>
<html>
<head>
	<link rel="icon" href="images/FAVICON.png" type="image/x-icon">
	<title>Welcome | Vance Social</title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body id="indexbody">
	<h1 style="color: white; text-align: center; font-size: 70px; font-family: Roboto;"><img id="indexlogo" src="images/logo.png" title="Vance" alt="V Logo" ></h1>
	<br><br>
	<form>
	<button formaction="Login.php" id="indexlog">Log In</button> <button formaction="create-account.php" id="indexbuton">Sign Up</button>
	</form>

</body>
</html>

');
}
?>


<!DOCTYPE html>
<html>
<head>
    
	<link rel="icon" href="images/FAVICON.png" type="image/x-icon">
	<title>Vance Social</title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>

<section id="nav2">
                <div>
  <ul>
    <li><a class="nava" href="index.php">Home</a></li>
    <li><a class="nava" href="#">Notifications</a></li>
    <li><a class="nava" href="#">Messages</a></li>
    <li><input type="text" placeholder="Search Vance" name=""></li>
    <li><div class="dropdown"><button class="dropbtn">User</button>
          <div class="dropdown-content">
    <a id="hged" href="My-Account.php">My Account</a>
    <a href="Change-password.php">Change Password</a>
    <a id="gred" href="logout.php">Logout</a>
  </div>
    </div></li>
  </ul>
</div>
</section>
<br>
<body >
        <br><br><br>
        
<section id="ag7">
        <div>
                <h1>Trending Hashtags</h1>
                <p><a href="">#Troftey</a></p>
                <p><a href="">#AFL</a></p>
                <p><a href="">#MUFC</a></p>
                <p><a href="">#DaveSaves</a> </p>
                <p><a href="">#Pogba</a></p>
                <p><a href="">#TigerWoods</a></p>
                <p><a href="">#Davidoliveinconcert</a></p>
                <p><a href="">#DeGea</a></p>
                <p><a href="">#Wizkid</a></p>
                <p><a href="">#PostMalone</a></p>
        </div>
</section>
<section id="last">
    <div>
                <nav>
                        <ul>
                                <li>
                                        <a href="#">About Us</a>
                                </li>
                                &#8226;
                                <li>
                                        <a href="#">Support</a>
                                </li>
                                &#8226;
                                <li>
                                        <a href="#">Press</a>
                                </li>
                                &#8226;
                                <li>
                                        <a href="#">API</a>
                                </li>
                                &#8226;
                                <li>
                                        <a href="#">Jobs</a>
                                </li>
                                &#8226;
                                <li>
                                        <a href="#">Privacy</a>
                                </li>
                                &#8226;
                                <li>
                                        <a href="#">Terms</a>
                                </li>
                                &#8226;
                                <li>
                                        <a href="#">Directory</a>
                                </li>
                                 &#8226;
                                <li>
                                        <a href="#">Profiles</a>
                                </li>
                                 &#8226;
                                <li>
                                        <a href="#">Hashtags</a>
                                </li>


                        </ul>

                        <p>&copy; 2019 Diso</p>
                </nav>
        </div>
</section>

<section id="d9786">
<?php
$showTimeline = False;
if (Login::isLoggedIn()) {
        $userid = Login::isLoggedIn();
        $showTimeline = True;
} else {
        die('
<!DOCTYPE html>
<html>
<head>
    <link rel="icon" href="images/FAVICON.png" type="image/x-icon">
    <title>Diso - THE TRUE NETWORK</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body id="indexbody">
    <h1 style="color: white; text-align: center; font-size: 70px; font-family: Roboto;"><img id="indexlogo" src="images/disologo.png" title="DISO" alt="Diso" ></h1>
    <br><br><br><br><br><br>
    <form>
    <button formaction="Login.php" id="indexlog">Log In</button> <button formaction="create-account.php" id="indexbuton">Sign Up</button>
    </form>

</body>
</html>

');
}
if (isset($_GET['postid'])) {
        Post::likePost($_GET['postid'], $userid);
}
if (isset($_POST['comment'])) {
        Comment::createComment($_POST['commentbody'], $_GET['postid'], $userid);
}
$followingposts = DB::query('SELECT posts.id, posts.body, posts.likes, users.`username` FROM users, posts, followers
WHERE posts.user_id = followers.user_id
AND users.id = posts.user_id
AND follower_id = :userid
ORDER BY posts.likes DESC;', array(':userid'=>$userid));
foreach($followingposts as $post) {
        echo "<article >
                                <div id='ipost-head'><img id='img' src='images/P9.jpg' > <span><b>
                                ". $post['username']."</b> </span></div>
                                <p id='ipostp'>".$post['body']."</p>";

        echo "<form action='index.php?postid=".$post['id']."' method='post'>";
        if (!DB::query('SELECT post_id FROM post_likes WHERE post_id=:postid AND user_id=:userid', array(':postid'=>$post['id'], ':userid'=>$userid))) {
        echo "<input id='like' type='submit' name='like' value='Like'>";
        } else {
        echo "<input id='unlike' type='submit' name='unlike' value='Unlike'>";
        }
        echo "<span>".$post['likes']."</span>
        </form>
        <form action='index.php?postid=".$post['id']."' method='post'>
        <textarea style='resize: none;' name='commentbody' rows='3' cols='50'></textarea>
        <input type='submit' name='comment' value='Comment'>
        </form>
        <br>


        ";
        
        Comment::displayComments($post['id']);
        echo "
        <br>
        </article><br><br>
        ";
}
?>
</section>
</body>
</html>

