<?php
class Post {
        public static function createPost($postbody, $loggedInUserId, $profileUserId) {
                if (strlen($postbody) > 250 || strlen($postbody) < 1) {
                        die('Incorrect length!');
                }
                if ($loggedInUserId == $profileUserId) {
                        DB::query('INSERT INTO posts VALUES (\'\', :postbody, NOW(), :userid, 0)', array(':postbody'=>$postbody, ':userid'=>$profileUserId));
                } else {
                        die('Incorrect user!');
                }
        }
        public static function likePost($postId, $likerId) {
                if (!DB::query('SELECT user_id FROM post_likes WHERE post_id=:postid AND user_id=:userid', array(':postid'=>$postId, ':userid'=>$likerId))) {
                        DB::query('UPDATE posts SET likes=likes+1 WHERE id=:postid', array(':postid'=>$postId));
                        DB::query('INSERT INTO post_likes VALUES (\'\', :postid, :userid)', array(':postid'=>$postId, ':userid'=>$likerId));
                } else {
                        DB::query('UPDATE posts SET likes=likes-1 WHERE id=:postid', array(':postid'=>$postId));
                        DB::query('DELETE FROM post_likes WHERE post_id=:postid AND user_id=:userid', array(':postid'=>$postId, ':userid'=>$likerId));
                }
        }
        public static function displayPosts($userid, $username, $loggedInUserId) {
                $dbposts = DB::query('SELECT * FROM posts WHERE user_id=:userid ORDER BY id DESC', array(':userid'=>$userid));
                $posts = "";
                foreach($dbposts as $p) {

                        $verified = False;
                if (DB::query('SELECT username FROM users WHERE username=:username', array(':username'=>$_GET['username']))) {
                $verified = DB::query('SELECT verified FROM users WHERE username=:username', array(':username'=>$_GET['username']))[0]['verified'];
        }


                        if (!DB::query('SELECT post_id FROM post_likes WHERE post_id=:postid AND user_id=:userid', array(':postid'=>$p['id'], ':userid'=>$loggedInUserId))) {
                                $posts .= "<article >
                                <h3 id='post-head'><?php echo $username; ?> <span><?php if ($verified) { echo ' <img id='postv' src='images/verified.png' title='Verified User' >'; } ?> </span></h3>
                                <p id='postp'>
                                ". htmlspecialchars($p['body']). "</p>

                                <form action='profile.php?username=$username&postid=".$p['id']."' method='post'>
                                        <input id= 'like' type='submit' name='like' value='like'>
                                        <span>".$p['likes']."</span>
                                </form>
                                <br>

</article><br><br>";
                        } else {
                                $posts .= "<article >
                                <h3 id='post-head'><?php echo $username; ?> <span><?php if ($verified) { echo ' <img id='postv' src='images/verified.png' title='Verified User' >'; } ?> </span></h3>
                                <p id='postp'>
                                ". htmlspecialchars($p['body'])."</p>
                                <form action='profile.php?username=$username&postid=".$p['id']."' method='post'>
                                        <input id= 'unlike' type='submit' name='unlike' value='unlike'>
                                        <span>".$p['likes']."</span>
                                </form>
                                <br>

</article><br><br>
                                ";
                        }
                }
                return $posts;
        }
}
?>