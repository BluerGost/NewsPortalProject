<?php
if (session_status() == PHP_SESSION_NONE)
{
    session_start();
}

?>
<html>
<head>
<!-- CSS File -->
<link rel="stylesheet" type="text/css" href="assets/css/navigationBar.css">

<!-- Bootstrap CSS File-->
<link rel="stylesheet" type="text/css" href="assets/css/lib/bootstrap.min.css">

<!-- Font Awesome CDN  -->
<link rel="stylesheet" type="text/css" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css">
</head>
<!----------------------------------Navigation Bar------------------------------->
<body>
<h1>Phoenix News</h1>
<nav class="navbar navbar-expand-lg navbar-light ">
    <div class="container-fluid">
        <a class="navbar-brand" href="index.php"><i class="fab fa-phoenix-framework"></i></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item active">
                    <a class="nav-link" href="index.php">Home <span class="sr-only">(current)</span></a>
                </li>
                <?php
                    if(isset($_SESSION['userId']))
                    {
                        echo "<li class='nav-item'>";
                        echo "<a class='nav-link' href='postNewNews.php'>Post News</a>";
                        echo "</li>";
                    }
                ?>
            </ul>

        </div>
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" href="#">
                    <img id="profile-pic"src="assets/img/naruto.jpg" class="rounded-circle" alt="Cinque Terre">
                </a>
            </li>

            <?php

            if(isset($_SESSION['userName']))
            {
                //Hi,Username
                echo"<li class='nav-item'>";
                echo "<a class='nav-link' href='#'>";
                echo "Hi,".$_SESSION['userName'];
                echo "</a>";
                echo "</li>";

                //Logout
                echo"<li class='nav-item'>";
                echo "<a  class='nav-link' href='logOutUser.php'>";
                echo "Logout";
                echo "</a>";
                echo "</li>";
            }
            else
            {
                echo"<li class='nav-item'>";
                echo "<a class='nav-link' href='logInUser.php'>";
                echo "LogIn";
                echo "</a>";
                echo "</li>";
            }
            ?>
            <li class="nav-item">
                <a class="nav-link" href="registerNewUser.php">Register</a>
            </li>
        </ul>
    </div>
</nav>


<!-- jQuery -->
<script type="text/javascript" src="assets/js/lib/jquery-3.3.1.min.js"></script>
<!-- Bootstrap JS (Boostrap,Pooper) -->
<script type="text/javascript" src="assets/js/lib/bootstrap.bundle.min.js"></script>

<!--JavaScript File of Phoenix News  -->
<script type="text/javascript" src="assets/js/newsPortal.js"></script>
</body>
</html>