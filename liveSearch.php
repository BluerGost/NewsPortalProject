<!DOCTYPE html>
<html>

<head>
    <!-- CSS File -->
    <link rel="stylesheet" type="text/css" href="assets/css/newsPortal.css">

</head>
<body>

<?php
include_once('dbConnect.php');
$q = $_GET['q'];
$q = '%' . $q . '%';
$q = preg_replace('/\s+/', '%',$q); //Replacing mltiple whitespace and newlines and tabs with a %
// $q = preg_replace('\s', '%',$q); //replacing white space with %

    $newsObj = new dbConnect();
    $result = $newsObj->getSearchResult($q);

    If(is_object($result))
    {
        foreach ($result as $row)
        {

            echo "<div class='col-md-3'>";
            //Show the News Information Using Card.
            echo "<div class='card text-center' style='width: 18rem;'>";
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
    }



?>
</body>
</html>