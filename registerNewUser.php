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
$userName = $firstName = $lastName = $email = $password = "";

//Variables for saving Error Messages
$userNameError = $firstNameError = $lastNameError = $emailError = $passwordError = "";


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

    if(empty($_POST['textFirstName']))
    {
        $firstNameError = "First Name is Required!";
    }
    else
    {
        $firstName = inputPreprocessed($_POST['textFirstName']);
    }

    if(empty($_POST['textLastName']))
    {
        $lastNameError = "Last Name is Required!";
    }
    else
    {
        $lastName = inputPreprocessed($_POST['textLastName']);
    }

    if(empty($_POST['textEmail']))
    {
        $emailError = "Email is Required!";
    }
    else
    {
        $email = inputPreprocessed($_POST['textEmail']);
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

    if($dbObj->addNewUser($userName,$firstName,$lastName,$email,$password)==true)//success
    {
        $dbSuccessMsg = "Successfully Added News To The Database";
    }
    else//Failed
    {
        $dbFailedMsg = "Failed To Add News To The Database";
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

        <h1 class="page-title">Register</h1>
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

            <!-- First Name -->
            <div class="form-group">
                <label for="firstName">First Name<span class="required-field">*</span></label>
                <input type="text" name="textFirstName" id="firstName"   class="form-control" placeholder="Enter First Name">
            </div>

            <!-- Last Name -->
            <div class="form-group">
                <label for="lastName">Last Name<span class="required-field">*</span></label>
                <input type="text" name="textLastName" id="lastName"   class="form-control" placeholder="Enter Last Name">
            </div>

            <!-- Email -->
            <div class="form-group">
                <label for="email">Email<span class="required-field">*</span></label>
                <input type="email" name="textEmail" id="email"   class="form-control" placeholder="Enter Email Address">
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

        if($firstNameError != "")
        {
            echo "<div class='alert alert-danger' role='alert'>",$firstNameError,"</div>";
        }
        if($lastNameError != "")
        {
            echo "<div class='alert alert-danger' role='alert'>",$lastNameError,"</div>";
        }
        if($emailError != "")
        {
            echo "<div class='alert alert-danger' role='alert'>",$emailError,"</div>";
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
