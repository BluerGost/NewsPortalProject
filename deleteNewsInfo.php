<?php
//If session not started then start the session.
if (session_status() == PHP_SESSION_NONE)
{
    session_start();
}
?>

<html>
<head>
    <meta charset="UTF-8">
    <title>Edit News</title>

    <!--    CSS FILE    -->
    <link rel="stylesheet" type="text/css" href="assets/css/editNewsInfo.css">

    <!-- Bootstrap CSS File-->
    <link rel="stylesheet" type="text/css" href="assets/css/lib/bootstrap.min.css">

    <!-- Font Awesome CDN  -->
    <link rel="stylesheet" type="text/css" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css">

    <!--Ckeditor(classic)-->
    <script type="text/javascript" src="assets/js/lib/ckeditor_classic.js"></script>
</head>
<body>
<?php

include_once("dbConnect.php");


//NewsId Variable
$newsId = "";
$authorId = "";


//DB insert message
$dbSuccessMsg = "";
$dbFailedMsg = "";

//Getting the Information of the News From the server.

//check if newsId was passed as a get request method.
if(isset($_GET['newsId']) && isset($_SESSION['userId']))
{
    //Setting the newsId variable
    $newsId = $_GET['newsId'];
    $authorId =  $_SESSION['userId'];
}
else//if there is not newsId in GET
{
    //Need Improvement: Alert the user That Link is incorrect then redirect.
    header("Refresh: 2; url=viewFullStory.php?newsId=$newsId");
}




if($_SERVER['REQUEST_METHOD']=='POST')
{

    $dbObj = new dbConnect();

    if($dbObj->deleteNews($newsId,$authorId)==true)//success
    {
        $dbSuccessMsg = "<strong>Successfully</strong> Deleted The News";
        header("Refresh: 2; url=index.php");//redirect to index page
    }
    else//Failed
    {
        $dbFailedMsg = "<strong>Failed</strong> To Delete The News";
    }

}//End of REQUEST_METHOD if statement

?>
<script>
    function redirectToFullStory()
    {
        window.location.href= 'viewFullStory.php?newsId=' + '<?php echo $newsId; ?>';
    }
</script>
<div class="container">
    <div id="editNewStory">

        <h1 class="page-title">Delete News</h1>
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
        <form method="post" action="">

            <div class="form-group">
                <label for="title">Are you sure you want to delete the news?<span class="required-field">*</span></label>
            </div>

            <button type="submit" class="btn btn-danger">YES</button>
            <button type="button" class="btn btn-success" onclick="redirectToFullStory()">NO</button>
        </form>


        <?php

        // Showing the error messages

//        if($authorIdError != "")
//        {
//            echo "<div class='alert alert-danger' role='alert'>",$authorIdError,"</div>";
//        }

        ?>
    </div><!--End of postNewStory Div-->

</div><!--End of Container Div-->



<!-- jQuery -->
<script type="text/javascript" src="assets/js/lib/jquery-3.3.1.min.js"></script>
<!-- Bootstrap JS (Boostrap,Pooper) -->
<script type="text/javascript" src="assets/js/lib/bootstrap.bundle.min.js"></script>




</body>
</html>
