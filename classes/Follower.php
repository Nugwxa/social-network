<?php
class Follower {
        public static function displayname($username) {
                $usernarm = DB::query('SELECT users.username FROM users WHERE username = :username', array(':username'=>$username));
                foreach($usernarm as $usaname) {
                        echo  $usaname['username'] ." </p> <hr />";
                }
        }
}
?>