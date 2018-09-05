<?php
if (session_status() == PHP_SESSION_NONE)
{
    session_start();
}
/*
This class Will Do all the connect and CRUD Operations of the News Portal Website.
*/
class dbConnect
{
    //Database Connection Information
    private $dbHost;
    private $dbUser;
    private $dbPassword;
    private $dbName; //name of the database

    //Connection Variable
    private $conn;

    public function __construct($dbHost="localhost",$dbUser="root",$dbPassword="",$dbName="newsPortal")
    {
         //Setting the Database Informations
         $this->dbHost = $dbHost;
         $this->dbUser = $dbUser;
         $this->dbPassword = $dbPassword;
         $this->dbName = $dbName; //name of the database

        //create a connection to the database
         $this->conn = mysqli_connect($dbHost,$dbUser,$dbPassword,$dbName) or die("Database Connection Problem".mysqli_connect_error());
    }


    //Will Be Called At the start of the Index Page
    public function getNewsList()
    {
        $query = "SELECT tblnews.newsId,title,description,urlToImage,publishedAt,
                          lastUpdated,typeOfNews,tblnews.newsId,avg_rating
                  FROM tblnews LEFT JOIN viewavgnewsrating
                  ON tblnews.newsId= viewavgnewsrating.newsId
                  ORDER BY  publishedAt DESC";
        $result = mysqli_query($this->conn,$query);

        if(mysqli_num_rows($result)>0)
        {
            return $result;
        }
        else
        {
            return -1;//error
        }
    }

    public function getSearchResult($title)
    {
        $query = "SELECT tblnews.newsId,title,description,urlToImage,publishedAt,
                    lastUpdated,typeOfNews,tblnews.newsId,avg_rating
                    FROM tblnews LEFT JOIN viewavgnewsrating
                    ON tblnews.newsId= viewavgnewsrating.newsId
                    WHERE title LIKE '" . $title . "'" .
                    "ORDER BY  publishedAt DESC";
        $result = mysqli_query($this->conn,$query);

        if(mysqli_num_rows($result)>0)
        {
            return $result;
        }
        else
        {
            return -1;//error
        }
    }


    //used in viewFullStory Page. Will fetch all the information for a particular news(except the tags).
    public function getFullNewsDetails($newsId)
    {
        if($newsId==null) //if no newsId was passed
        {
            return -1;//error
        }
        else
        {
            $query = "SELECT tblnews.newsId,title,description,urlToImage,publishedAt,
                             lastUpdated,typeOfNews,tblnews.newsId,avg_rating,authorId
                      FROM tblnews LEFT JOIN viewavgnewsrating
                      ON tblnews.newsId= viewavgnewsrating.newsId
                      WHERE tblnews.newsId = $newsId";
            $result = mysqli_query($this->conn,$query);

            if(mysqli_num_rows($result)>0)
            {
                return $result;
            }
            else
            {
                return -1;//error
            }
        }
    }

    public function getNewsTags($newsId)
    {
        if($newsId==null) //if no newsId was passed
        {
            return -1;//error
        }
        else
        {
            $query = "SELECT tbltag.tag FROM tbltag WHERE newsId=$newsId";
            $result = mysqli_query($this->conn,$query);

            if(mysqli_num_rows($result)>0)
            {
                return $result;
            }
            else
            {
                return -1;//error
            }
        }
    }

    public function addNewNews($title=null,$description=null,$urlToImage=null,$typeOfNews=null,$authorId=null,$tags=null)
    {
        if($title!=null && $description!=null && $typeOfNews!=null && $authorId!=null && $tags!=null)
        {
            $query = "INSERT INTO tblNews(title,description,urlToImage,typeOfNews,authorId)
                      VALUES ('$title','$description','$urlToImage','$typeOfNews',$authorId)";
            if(mysqli_query($this->conn,$query))
            {
                //get the last Auto-increment id.
                $newsId = mysqli_insert_id($this->conn);

                //inserting tags of the news in the tblTags.
                if(is_array($tags))
                {
                    foreach($tags as $tag)
                    {
                        $queryTags = "INSERT INTO tblTag(newsId,tag)
                                  VALUES ($newsId,'$tag')";

                        //inserting All the tags
                        mysqli_query($this->conn,$queryTags);
                    }
                }
                return true;//Success in Adding News to the Database.

            }

        }
        else
        {
            return false;//Failed to insert news.
        }
    }

    public function addNewUser($userName=null,$firstName=null,$lastName=null,$email=null,$password=null)
    {
        $query = "INSERT INTO tblUser(userName,firstName,lastName,email,password)
                  VALUES ('$userName','$firstName','$lastName','$email','$password')";

        if($userName=null && $firstName=null && $lastName=null && $email=null && $password=null)
        {
            if (mysqli_query($this->conn, $query))
            {
                return true;
            }
            else
            {
                return false;
            }
        }
        else
        {
            return false;
        }
    }




    public function logInUser($userName,$password)
    {
        $query = "SELECT userId,userName
                  FROM tbluser
                  WHERE userName='$userName' AND password='$password';";
        $result = mysqli_query($this->conn, $query);
        if(mysqli_num_rows($result)>0)
        {
            $result = mysqli_fetch_array($result);
            $_SESSION['userId'] = $result['userId'];
            $_SESSION['userName'] = $result['userName'];
            return true;
        }
        else
        {
            return false;
        }
    }


    public function logOutUser()
    {

        // remove all session variables
        session_unset();

        // destroy the session
        session_destroy();
    }


//    editNewsInfo Page

    public function editNewsInfo($title=null,$description=null,$urlToImage=null,$typeOfNews=null,$authorId=null,$tags=null, $newsId=null)
    {
        if($title!=null && $description!=null && $typeOfNews!=null && $authorId!=null && $newsId!=null)
        {
            $query = "UPDATE tblnews
                      SET title = '$title' , description = '$description',
                          urlToImage = '$urlToImage',
                          typeOfNews = '$typeOfNews'
                      WHERE newsId=$newsId AND authorId=$authorId;";
            if(mysqli_query($this->conn,$query))
            {
                if(is_array($tags))//If new tags are selected.
                {
                    //Drop all the previous tags
                    $queryDeletePrevTags = "DELETE FROM tbltag WHERE newsId='$newsId'";
                    mysqli_query($this->conn,$queryDeletePrevTags);

                    //inserting tags of the news in the tblTags.
                    foreach($tags as $tag)
                    {
                        $queryTags = "INSERT INTO tblTag(newsId,tag)
                                  VALUES ($newsId,'$tag')";

                        //inserting All the tags
                        mysqli_query($this->conn,$queryTags);
                    }

                }
            }
            return true;//Success in Adding News to the Database.
        }
        else
        {
            return false;//Failed to insert news.
        }
    }
    public function deleteNews($newsId = null ,$authorId = null)
    {
        if($newsId != null && $authorId != null)
        {
            $queryDeleteTags = "DELETE FROM tbltag WHERE newsId=$newsId";
            $queryDeleteNewsInfo = "DELETE FROM tblnews 
                                WHERE newsId=$newsId AND authorId=$authorId";
            if(mysqli_query($this->conn,$queryDeleteTags))
            {
                if(mysqli_query($this->conn,$queryDeleteNewsInfo))
                {
                    return true;
                }
            }
        }
        else
        {
            return false;
        }


    }


}//end of the class