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

<!----------------------------------Navigation Bar------------------------------->
<?php include_once('navigationBar.php'); ?>


<?php

include_once("dbConnect.php");


//NewsId Variable
$newsId = "";
$authorId = "";

//Variables for saving data
$title = $description = $urlToImage = $typeOfNews = $tags = "";

//Variables for saving Error Messages
$titleError = $descriptionError = $urlToImageError = $typeOfNewsError = $authorIdError = $tagError = "";

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

        $dbObj = new dbConnect();
        $newsDetails = $dbObj->getFullNewsDetails($newsId);
        $newsTags = $dbObj->getNewsTags($newsId);

        //checks if both of the passed result is an object.
        if(is_object($newsDetails))
        {
            $newsDetails = mysqli_fetch_array($newsDetails);
            //take the object as an Array
        }
        else//If error happens(not an array)
        {
            $dbFailedMsg = "<br>Data Fetch From Database Faced <strong>ERROR<strong><br>";
        }

    }
    else//if there is not newsId in GET
    {
        //Need Improvement: Alert the user That Link is incorrect then redirect.
        header('Location: index.php');
    }




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
//            $tagError = "Tags of News is Required!";
        }
        else//if selectTags is selected
        {
            $tags = $_POST['selectTags'];
        }

        echo "title",$title,"<br>";
        echo "description",$description,"<br>";
        echo "urlToImage",$urlToImage,"<br>";
        echo "type of news ",$typeOfNews,"<br>";
        echo "tags",$tags,"<br>";

        echo "newsId",$newsId,"<br>";
        echo "authorId",$authorId,"<br>";

        $dbObj = new dbConnect();

        if($dbObj->editNewsInfo($title,$description,$urlToImage,$typeOfNews,$authorId,$tags,$newsId)==true)//success
        {
            $dbSuccessMsg = "<strong>Successfully</strong> Edited The News Information";
            header("Refresh: 2; url=viewFullStory.php?newsId=$newsId");
        }
        else//Failed
        {
            $dbFailedMsg = "<strong>Failed</strong> To Edited The News Information";
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
    <div id="editNewStory">

        <h1 class="page-title">Edit News</h1>
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
                <label for="title">Title<span class="required-field">*</span></label>
                <input type="text" name="textTitle" id="title"   class="form-control" placeholder="Enter News Title" value="<?php echo $newsDetails['title']?>">
            </div>

            <div class="form-group">
                <label for="description">Description<span class="required-field">*</span></label>
                <textarea class="form-control" name="textDescription" id="description" rows="12"  placeholder="Enter News Decription" ><?php echo $newsDetails['description']?></textarea>
            </div>

            <div class="form-group">
                <label for="urlToImage">URL To Image</label>
                <input type="text" class="form-control" name="textUrlToImage"  id="urlToImage" placeholder="Enter Image Url" value="<?php echo $newsDetails['urlToImage']?>">
            </div>

            <div class="form-group">
                <label for="typeOfNews">News Type<span class="required-field">*</span></label>
                <select class="form-control" name="selectTypeOfNews" id="typeOfNews">
                    <option selected disabled hidden>Choose A News Type</option>     <!-- So that we cant select the first option in the Dropdown -->
                    <option value="public" class="text-success" <?php if($newsDetails['typeOfNews']=='public') echo 'selected';?>>public</option>
                    <option value="private" class="text-info" <?php if($newsDetails['typeOfNews']=='private') echo 'selected';?>>private</option>
                </select>
            </div>
            <?php
            //News Tags
            if(is_object($newsTags))
            {
                echo "<div id='previous-Taglist'>Previous Tags Were:";
                foreach ($newsTags as $row)
                {
                    echo "<a href=''>",$row['tag'],"</a>";
                }
                echo "</div>";
            }
            //End of  News Tags
            ?>
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
//        if($tagError != "")
//        {
//            echo "<div class='alert alert-danger' role='alert'>",$tagError,"</div>";
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
