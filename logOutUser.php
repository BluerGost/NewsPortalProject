<?php
/**
 * Created by PhpStorm.
 * User: HP
 * Date: 8/29/2018
 * Time: 1:33 AM
 */

include_once ('dbConnect.php');

$dbobj = new dbConnect();

$dbobj->logOutUser();

header("Location: index.php");