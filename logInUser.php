<?php
if (session_status() == PHP_SESSION_NONE)
{
    session_start();
}
?>
<html>
<head>
    <meta charset="UTF-8">
    <title>Register New User</title>

    <!--    CSS FILE    -->
    <link rel="stylesheet" type="text/css" href="assets/css/registerNewUser.css">

    <!-- Bootstrap CSS File-->
    <link rel="stylesheet" type="text/css" href="assets/css/lib/bootstrap.min.css">

    <!-- Font Awesome CDN  -->
    <link rel="stylesheet" type="text/css" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css">

    <!--Ckeditor(classic)-->
    <script type="text/javascript" src="assets/js/lib/ckeditor_classic.js"></script>
</head>
<body>

<!----------------------------------Navigation Bar------------------------------->
<?php include_once('navigationBar.php'); ?>


<?php

include_once("dbConnect.php");

//Variables for saving data
$userName = $password = "";

//Variables for saving Error Messages
$userNameError = $passwordError = "";


//DB insert message
$dbSuccessMsg = "";
$dbFailedMsg = "";

if($_SERVER['REQUEST_METHOD']=='POST')
{
    if(empty($_POST['textUserName']))
    {
        $userNameError = "User Name is Required!";
    }
    else
    {
        $userName = inputPreprocessed($_POST['textUserName']);
    }

    if(empty($_POST['textPassword']))
    {
        $passwordError = "Password is Required!";
    }
    else
    {
        $password = inputPreprocessed($_POST['textPassword']);
    }


    $dbObj = new dbConnect();

    if($dbObj->logInUser($userName,$password)==true)//success
    {
        $dbSuccessMsg = "Successfully Logged In";
        header("Refresh: 2; url=index.php");
    }
    else//Failed
    {
        $dbFailedMsg = "Wrong Username or Password";
    }




}//End of REQUEST_METHOD if statement

// Prepossessing the input datas
function inputPreprocessed($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    return $data;
}
?>
<div class="container">
    <div id="registerNewUser">

        <h1 class="page-title">Log-In</h1>
        <!--  Form to take the New News Values-->
        <?php

        // Showing the error messages
        if($dbSuccessMsg != "")
        {
            echo "<div class='alert alert-success' role='alert'>",$dbSuccessMsg,"</div>";
        }

        if($dbFailedMsg != "")
        {
            echo "<div class='alert alert-warning' role='alert'>",$dbFailedMsg,"</div>";
        }
        ?>
        <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">

            <!--Username -->
            <div class="form-group">
                <label for="userName">User Name<span class="required-field">*</span></label>
                <input type="text" name="textUserName" id="userName"   class="form-control" placeholder="Choose a User Name">
            </div>

            <!-- Password -->
            <div class="form-group">
                <label for="password">Password<span class="required-field">*</span></label>
                <input type="password" name="textPassword" id="password"   class="form-control" placeholder="Enter Password">
            </div>

            <button type="submit" class="btn btn-primary">Submit</button>
        </form>


        <?php

        // Showing the error messages
        if($userNameError != "")
        {
            echo "<div class='alert alert-danger' role='alert'>",$userNameError,"</div>";
        }

        if($passwordError != "")
        {
            echo "<div class='alert alert-danger' role='alert'>",$passwordError,"</div>";
        }

        ?>
    </div><!--End of postNewStory Div-->

</div><!--End of Container Div-->





</body>
</html>
