<?php
if (session_status() == PHP_SESSION_NONE)
{
session_start();
}
?>
<html>
<head>
    <meta charset="UTF-8">
    <title>Post a New News</title>

    <!--    CSS FILE    -->
    <link rel="stylesheet" type="text/css" href="assets/css/postNewNews.css">

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
if(isset($_SESSION['userId']))
{
    header('Location: index.php');
}
include_once("dbConnect.php");

//Variables for saving data
$title = $description = $urlToImage = $typeOfNews = $authorId = $tags = "";


$authorId = $_SESSION['userId'];//dummy value



//Variables for saving Error Messages
$titleError = $descriptionError = $urlToImageError = $typeOfNewsError = $authorIdError = $tagError = "";

//DB insert message
$dbSuccessMsg = "";
$dbFailedMsg = "";

if($_SERVER['REQUEST_METHOD']=='POST')
{
    if(empty($_POST['textTitle']))
    {
        $titleError = "News Title is Required!";
    }
    else
    {
        $title = inputPreprocessed($_POST['textTitle']);
    }

    if(empty($_POST['textDescription']))
    {
        $descriptionError = "News Description Required!";
    }
    else
    {
        $description = inputPreprocessed($_POST['textDescription']);
    }


    //url to Image is not required field so pass Null when no url given.
    if(empty($_POST['textUrlToImage']))
    {
        $urlToImage = null;
    }
    else
    {
        $urlToImage = inputPreprocessed($_POST['textUrlToImage']);
    }

    if(empty($_POST['selectTypeOfNews']))
    {
        $typeOfNewsError = "Type of News is Required!";
    }
    else
    {
        $typeOfNews = inputPreprocessed($_POST['selectTypeOfNews']);
    }

    if(empty($_POST['selectTags']))
    {
        $tagError = "Tags of News is Required!";
    }
    else
    {
        $tags = $_POST['selectTags'];
    }

    echo "title",$title,"<br>";
    echo "description",$description,"<br>";
    echo "urlToImage",$urlToImage,"<br>";
    echo "type of news ",$typeOfNews,"<br>";
    echo "tags",$tags,"<br>";
    echo "authorId",$authorId,"<br>";

    $dbObj = new dbConnect();

    if($dbObj->addNewNews($title,$description,$urlToImage,$typeOfNews,$authorId,$tags)==true)//success
    {
        $dbSuccessMsg = "<strong>Successfully</strong> Added News To The Database";
        header("Refresh: 2; url=index.php");
    }
    else//Failed
    {
        $dbFailedMsg = "<strong>Failed</strong> To Add News To The Database";
    }




}//End of REQUEST_METHOD if statement

    // Prepossessing the input datas
    function inputPreprocessed($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
?>
<div class="container">
    <div id="postNewStory">

        <h1 class="page-title">Post News</h1>
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

            <div class="form-group">
                <label for="title">Title<span class="required-field">*</span></label>
                <input type="text" name="textTitle" id="title"   class="form-control" placeholder="Enter News Title">

            </div>

            <div class="form-group">
                <label for="description">Description<span class="required-field">*</span></label>
                <textarea class="form-control" name="textDescription" id="description" rows="12"  placeholder="Enter News Decription" ></textarea>
            </div>

            <div class="form-group">
                <label for="urlToImage">URL To Image</label>
                <input type="text" class="form-control" name="textUrlToImage"  id="urlToImage" placeholder="Enter Image Url">
            </div>

            <div class="form-group">
                <label for="typeOfNews">News Type<span class="required-field">*</span></label>
                <select class="form-control" name="selectTypeOfNews" id="typeOfNews">
                    <option selected disabled hidden>Choose A News Type</option>     <!-- So that we cant select the first option in the Dropdown -->
                    <option value="public" class="text-success">public</option>
                    <option value="private" class="text-info">private</option>
                </select>
            </div>


            <div class="form-group">
                <label for="tags">News Tags<span class="required-field">*</span></label>
                <select multiple class="form-control" name="selectTags[]" id="tags">
                    <option selected disabled hidden>Choose News Tags</option>   <!-- So that we cant select the first option in the Dropdown -->
                    <option value="sports">sports</option>
                    <option value="politics">politics</option>
                    <option value="travel">travel</option>
                    <option value="health">health</option>
                    <option value="money">money</option>
                    <option value="entertainment">entertainment</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>


        <?php

            // Showing the error messages
            if($titleError != "")
            {
                echo "<div class='alert alert-danger' role='alert'>",$titleError,"</div>";
            }

            if($descriptionError != "")
            {
                echo "<div class='alert alert-danger' role='alert'>",$descriptionError,"</div>";
            }
            if($urlToImageError != "")
            {
                echo "<div class='alert alert-danger' role='alert'>",$urlToImageError,"</div>";
            }
            if($typeOfNewsError != "")
            {
                echo "<div class='alert alert-danger' role='alert'>",$typeOfNewsError,"</div>";
            }
            if($authorIdError != "")
            {
                echo "<div class='alert alert-danger' role='alert'>",$authorIdError,"</div>";
            }
            if($tagError != "")
            {
                echo "<div class='alert alert-danger' role='alert'>",$tagError,"</div>";
            }
        ?>
    </div><!--End of postNewStory Div-->

</div><!--End of Container Div-->





</body>
</html>
