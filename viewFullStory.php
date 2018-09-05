<?php
//If session not started then start the session.
if (session_status() == PHP_SESSION_NONE)
{
    session_start();
}

    //NewsId Variable
    $newsId = "";


    //check if newsId was passed as a get request method.
    if(isset($_GET['newsId']))
    {
        //Setting the newsId variable
        $newsId = $_GET['newsId'];

        //setting the session variable
        $_SESSION["newsId"] = $newsId;

        include_once('dbConnect.php');
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
            echo "<br>Data Fetch From Database Faced <strong>ERROR<strong><br>";
        }

    }
    else
    {
        //Need Improvement: Alert the user That Link is incorrect then redirect.
        header('Location: index.php');
    }
?>
<html>
<head>

    <!-- CSS File -->
    <link rel="stylesheet" type="text/css" href="assets/css/viewFullStory.css">

    <!-- Bootstrap CSS File-->
    <link rel="stylesheet" type="text/css" href="assets/css/lib/bootstrap.min.css">

    <!-- Font Awesome CDN  -->
    <link rel="stylesheet" type="text/css" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css">


    <?php
        //Adding the News Title as the Page Title
        echo "<title>",$newsDetails['title'] ,"</title>";
    ?>
</head>
<body>

<!----------------------------------Navigation Bar------------------------------->
<?php include_once('navigationBar.php'); ?>


<div class="container">
    <!--    START Of Full Story Div     -->
    <div class="fullStory">
        <?php

            //Modify(Edit,Delete) Button(only for author)
            echo "<div id='modifyNews'>";
            if(isset($_SESSION['userId']) && $_SESSION['userId']==$newsDetails['authorId'])
            {
                echo "<a href='deleteNewsInfo.php?newsId=",$newsId,"' class='btn btn-outline-danger' target='_self'><i class='fas fa-trash-alt'></i></a>";
                echo "<a href='editNewsInfo.php?newsId=",$newsId,"' class='btn btn-outline-info' target='_self' ><i class='fas fa-pencil-alt'></i></a>";
            }
            else
            {
                echo "<a class='btn btn-outline-danger disabled invisible'><i class='fas fa-trash-alt'></i></a>";
                echo "<a href='editNewsInfo.php' class='btn btn-outline-info disabled invisible' target='_self' ><i class='fas fa-pencil-alt'></i></a>";
            }
            echo "</div>";
            //End of Modify Option


            echo "<h2 class='title'>",$newsDetails['title'],"</h2>";

            echo "<div class='publishedAt'>";

            echo "Published At: " , date_format(date_create($newsDetails['publishedAt']),"d/m/Y"), "<br>";

            echo "</div>";
            //     END Of Published At Div

            if($newsDetails['urlToImage']==null)//if there is no image available
            {
                echo "<img src='assets/img/noImageAvailable.jpg'  class='img-thumbnail' alt='No Image'>";
            }
            else
            {
                echo "<img src='",$newsDetails['urlToImage'],"'  class='img-thumbnail' alt='Full Story Pic'>";
            }

            echo "<p class='description'>",$newsDetails['description'],"</p>";

            echo "<div id='fullStory-Rating'>Rating: <i class='fas fa-star'></i>",round($newsDetails['avg_rating']),"/10</div>";

            //News Tags
            if(is_object($newsTags))
            {
                echo "<div id='fullStory-Taglist'>Tag:";
                foreach ($newsTags as $row)
                {
                    echo "<a href=''>",$row['tag'],"</a>";
                }
                echo "</div>";
            }
            //End of  News Tags

        ?>

   </div><!-- end of fullStory div-->
</div><!--end of container div-->

<!-- jQuery -->
<script type="text/javascript" src="assets/js/lib/jquery-3.3.1.min.js"></script>
<!-- Bootstrap JS (Boostrap,Pooper) -->
<script type="text/javascript" src="assets/js/lib/bootstrap.bundle.min.js"></script>

<!--JavaScript File of Phoenix News  -->
<script type="text/javascript" src="assets/js/newsPortal.js"></script>
</body>
</html>