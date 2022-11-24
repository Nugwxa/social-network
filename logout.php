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
<html style="overflow: hidden;">
<head>
        <link rel="icon" href="images/FAVICON.png" type="image/x-icon">
        <title>Logout | Vance Social&trade;</title>
        <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>

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
    <a href="change-password.php">Change Password</a>
  </div>
    </div></li>
  </ul>
</div>
        </section>

<section id="logout">
        <div><h1>LOGOUT</h1></div>
<p id="q1234" style="color: white; text-align: center; font-family: agencyr; ">Are you sure you want to log out ?</p>
<form id="foorm" action="logout.php" method="post">

<input style="margin-left: 4%;" type="checkbox" name="alldevices" value="alldevices"><a  id="e5123"> Logout of all devices </a><br><br>

<input style="background-color: #ed2089" id="buton" type="submit" name="confirm" value="Confirm">
</form><br>
</section>
</body>

<footer id="last">
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
                        </ul>
                </nav>
        </div>
</footer>

</html>