

-- SQL Queries:


-- Get all the information From user table.
SELECT *
FROM tblUser;


-- Get all the information from news table.
SELECT *
FROM tblNews;

-- Get Average Rating of a News.
SELECT avg(rating)
FROM tblNews  JOIN tblRating
ON tblNews.newsId  = tblRating.newsId
WHERE tblNews.newsId = $newsId;


-- Get all the Tags of a News.
SELECT tag
FROM tblNews  JOIN tblTag
ON tblNews.newsId  = tblTag.newsId
WHERE newsId = $newsId;




-- Make a VIEW:(In Development)

-- This view returns the average ratings of all the news
CREATE OR REPLACE VIEW viewAvgNewsRating AS
  SELECT newsId,AVG(rating) as avg_rating
  FROM tblRating
  GROUP BY newsId;


-- -------------------------- INDEX PAGE -----------------------------------


-- Build the Summary of News In the Index Page
SELECT tblnews.newsId,title,description,urlToImage,publishedAt,
       lastUpdated,typeOfNews,tblnews.newsId,avg_rating
FROM tblnews LEFT JOIN viewavgnewsrating
ON tblnews.newsId= viewavgnewsrating.newsId;
-- Use Order By


-- ------------------------------ viewFullStory PAGE --------------------------

-- Get News Details of a Particular News using News ID.(Note: Repalce the 5 with PHP newsId variable)
SELECT tblnews.newsId,title,description,urlToImage,publishedAt,
  lastUpdated,typeOfNews,tblnews.newsId,avg_rating
FROM tblnews LEFT JOIN viewavgnewsrating
    ON tblnews.newsId= viewavgnewsrating.newsId
WHERE tblnews.newsId = 5;

-- Get Tags of a Particular News using News ID.(Note: Repalce the 5 with PHP newsId variable)
-- Also used in index page.
SELECT distinct  tbltag.tag
FROM tbltag
WHERE newsId=5;





