<?php 

/**
 * creates a table called users with columns: userID username password email firstName lastName totalMoney revenue 
 * loss userID watch_list1 watch_list2 watch_list3 watch_list4 watch_list5 watch_list6 watch_list7 watch_list8
 * watch_list9 watch_list10 watch_list11 watch_list12 watch_list13 watch_list14 watch_list15 watch_list16 
 * watch_list17 watch_list18 watch_list19 watch_list20
 */


require_once '/../access/logInfo.php'; //pulls up data from logInfo.php
$conn = new mysqli($hn, $un, $pw, $db); //creates new mysqli object called conn with all the login info


if ($conn->connect_error) die($conn->connect_error); //if the data is wrong, then terminate and call the error

createTable($conn);


function createTable($conn) {
    $tableName = "users";
    

    //newly learned, replace this with heredoc. much easier
    $query = "CREATE TABLE $tableName ( userID INT(5) UNSIGNED NOT NULL AUTO_INCREMENT KEY, username VARCHAR(16) NOT NULL, password VARCHAR(128) NOT NULL," .
    "email VARCHAR(128) NOT NULL, firstName VARCHAR(32) NOT NULL, lastName VARCHAR(32) NOT NULL, totalMoney DOUBLE(10,2) UNSIGNED NOT NULL, revenue DOUBLE(10,2) UNSIGNED NOT NULL," .
    " loss DOUBLE(10,2) UNSIGNED NOT NULL, watch_list1 CHAR(5), watch_list2 CHAR(5), watch_list3 CHAR(5), watch_list4 CHAR(5), watch_list5 CHAR(5)" .
    ", watch_list6 CHAR(5), watch_list7 CHAR(5), watch_list8 CHAR(5), watch_list9 CHAR(5), watch_list10 CHAR(5), watch_list11 CHAR(5), " .
    "watch_list12 CHAR(5), watch_list13 CHAR(5), watch_list14 CHAR(5), watch_list15 CHAR(5), watch_list16 CHAR(5), watch_list17 CHAR(5), " .
    "watch_list18 CHAR(5), watch_list19 CHAR(5), watch_list20 CHAR(5))";
        
    $result = $conn -> query($query);
    if (!$result)   echo "INSERT failed: $query <br>" . $conn->error . "<br><br>";
        
    
}






?>