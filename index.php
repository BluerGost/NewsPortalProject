<?php
//If session not started then start the session.
if (session_status() == PHP_SESSION_NONE)
{
    session_start();
}



include_once("dbConnect.php");
?>

<!DOCTYPE html>
<html>
<head>
	<title>Phoenix News, The News That Burns Like Fire.</title>

<!-- CSS File -->
<link rel="stylesheet" type="text/css" href="assets/css/newsPortal.css">

<!-- Bootstrap CSS File-->
<link rel="stylesheet" type="text/css" href="assets/css/lib/bootstrap.min.css">

<!-- Font Awesome CDN  -->
<link rel="stylesheet" type="text/css" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css">

    <script>
    //     Script For LiveSearch
        function showNews(str) {
            // if (str=="") {
            //     document.getElementById("searchResult").innerHTML="";
            //     return;
            // }
            if (window.XMLHttpRequest) {
                // code for IE7+, Firefox, Chrome, Opera, Safari
                xmlhttp=new XMLHttpRequest();
            } else { // code for IE6, IE5
                xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
            }
            xmlhttp.onreadystatechange=function() {
                if (this.readyState==4 && this.status==200) {
                    document.getElementById("searchResult").innerHTML=this.responseText;
                }
            }
            xmlhttp.open("GET","liveSearch.php?q="+str,true);
            xmlhttp.send();
        }

    </script>
</head>
<body>

<!----------------------------------Navigation Bar------------------------------->
<?php include_once('navigationBar.php'); ?>

<!--------------------------------------Feature Story-------------------------------------->

<div id="featuredNews" class="carousel slide" data-ride="carousel">
    <ol class="carousel-indicators">
        <li data-target="#featuredNews" data-slide-to="0" class="active"></li>
        <li data-target="#featuredNews" data-slide-to="1"></li>
        <li data-target="#featuredNews" data-slide-to="2"></li>
    </ol>
    <div class="carousel-inner">
        <div class="carousel-item active">
            <img class="d-block  w-100" src="assets/img/haikyuu.jpg" alt="First slide">
            <div class="carousel-caption">
                <h3>New York</h3>
                <p>We love the Big Apple!</p>
            </div>
        </div>
        <div class="carousel-item">
            <img class="d-block  w-100"src="assets/img/naruto.jpg" alt="Second slide">
            <div class="carousel-caption">
                <h3>New York</h3>
                <p>We love the Big Apple!</p>
            </div>
        </div>
        <div class="carousel-item">
            <img class="d-block  w-100"src="assets/img/onepiece.jpg" alt="Third slide">
            <div class="carousel-caption">
                <h3>New York</h3>
                <p>We love the Big Apple!</p>
            </div>
        </div>
    </div>
    <a class="carousel-control-prev" href="#featuredNews" role="button" data-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
    </a>
    <a class="carousel-control-next" href="#featuredNews" role="button" data-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
    </a>
</div>

<!--------------------------------------Search Bar------------------------------------------>
<br>
<br>
<div class="container">
    <form>
        <div class="input-group input-group-lg">
            <div class="input-group-prepend">
                <span class="input-group-text" id="inputGroup-sizing-lg"><i class="fas fa-search"></i></span>
            </div>
            <!-- Search Input -->
            <input name="liveSearch" onkeyup="showNews(this.value)" type="text" class="form-control" aria-label="Search" aria-describedby="inputGroup-sizing-default" placeholder="Seach News...">
        </div>
    </form>
</div>
<br>

<!-----------------------------------Matched News Summery----------------------------------->
<div class="container-fluid">

    <div class="row align-items-start justify-content-center">
        <!--Left Side of Page-->
        <div  class="col">
            <div id="searchResult" class="row">
            <?php
                $newsObj = new dbConnect();
                $result = $newsObj->getNewsList();


                foreach ($result as $row)
                {

                    echo "<div class='col-md-3'>";
                    //Show the News Information Using Card.
                    echo "<div class='card text-center'>";
                    echo "<div class='card-header bg-success'>",$row['typeOfNews'],"</div>";
                    if($row['urlToImage']==null)//if there is no image available
                    {
                        echo "<img class='card-img-top' src='assets/img/noImageAvailable.jpg' alt='No Image'>";
                    }
                    else
                    {
                        echo "<img class='card-img-top' src='",$row['urlToImage'], "' alt='No Image' style='width:100%'>";
                    }

                    echo "<div class='card-body'>";
                    //Title
                    echo "<h3 class='card-title'>",$row['title'],"</h3>";
                    //Description
                    echo "<p class='card-text'>",substr($row['description'], 0, 40),".....</p>";
                    //Rating
                    echo "<p class='card-text'>Rating: <i class='fas fa-star'></i>",round($row['avg_rating']),"/10</p>";

                    //Tags

                    $newsTags = $newsObj->getNewsTags($row['newsId']);
                    if(is_object($newsTags))
                    {
                        $tags = "";
                        foreach ($newsTags as $rowTag)
                        {
                            $tags .= $rowTag['tag'] . ",";
                        }
                        $tags = rtrim($tags,",");//removing the extra last comma(,)

                        echo "<p class='card-text'><i class='fas fa-tags' data-toggle='popover' title='Tags' data-placement='top' data-content='".$tags."'></i></p>"; //Problem
                    }


                    //Button Link To Full Story
                    echo "<a href='viewFullStory.php?newsId=",$row['newsId'] ,"' class='btn btn-primary' target='_blank'>See Full Story</a>";

                    //Show Published Date
                    echo "<p class='card-text'><small class='text-muted'>Published At: ", date_format(date_create($row['publishedAt']),"d/m/Y"),"</small></p>";

                    echo "</div>";//end of card-content div
                    echo "</div>";//end of card div

                    echo "</div>";//end of col-3 div
                }
            ?>


            </div>

        </div>
    </div>

</div>



<!-- jQuery -->
<script type="text/javascript" src="assets/js/lib/jquery-3.3.1.min.js"></script>
<!-- Bootstrap JS (Boostrap,Pooper) -->
<script type="text/javascript" src="assets/js/lib/bootstrap.bundle.min.js"></script>

<!--JavaScript File of Phoenix News  -->
<script type="text/javascript" src="assets/js/newsPortal.js"></script>
</body>
</html>