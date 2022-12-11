<?php
include('./classes/DB.php');
include('./classes/Login.php');
include('./classes/Post.php');
include('./classes/Comment.php');
include('./classes/Follower.php');
?>


<!DOCTYPE html>
<html>
<head>
    
	<link rel="icon" href="images/FAVICON.png" type="image/x-icon">
	<title>Home | Vance Social</title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body >
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
                <title>Welcome | Vance Social</title>
                <link rel="stylesheet" type="text/css" href="css/style.css">
        </head>
        <body class="index-body">
        
                <div id="logo-container">
                        <div>
                                <img id="index-logo" src="images/Landing/Troftey_logo(Landing).png" title="Vance" alt="V Logo" >
                        </div>
                        <div>
                                <button class="index-btn" id="index-log-btn">Log In</button> <button class="index-btn" id="index-sign-btn">Sign Up</button>
                        </div>
                </div>
                
                <script type="text/javascript">
                        document.getElementById("index-log-btn").onclick = function () {
                                location.href = "login.php";
                        };
        
                        document.getElementById("index-sign-btn").onclick = function () {
                                location.href = "create-account.php";
                        };
                </script>
        </body>
        </html>

');
}
if (isset($_GET['postid'])) {
        //I like this, extracting business logic into a different class is a good idea
        Post::likePost($_GET['postid'], $userid);
}
if (isset($_POST['comment'])) {
        Comment::createComment($_POST['commentbody'], $_GET['postid'], $userid);
}

//One starting point for you is the way you arrange your code.
//You should always aim to seperate concerns, i have noticed alot of DB specific code in your views and alot of buisiness logic is present in these views.
//Ideally you want to separate your code into layers.
//1. The infrastucture layer - This includes infratructure concerns like Data access and storage
//2. Application logic - This layer should encapsulate all the business logic, things like fetching a user by id, creating a user,
//Creating post, updating passwords etc should be in this layer, you did a bit of this in the post and comments classes. 
//You should not have SQL Statements here, they should be in classes in the infrastructure layer. You can call those classes from this layer
//3. The presentation layer is the files that the iser interacts with i.e this class, you should only have user interaction logic here, any logic like fecthing data done below belongs in the application layer.
//Think about this and we can have a chat to see how to seperate these concerns into differnet layers.
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
</body>
</html>

