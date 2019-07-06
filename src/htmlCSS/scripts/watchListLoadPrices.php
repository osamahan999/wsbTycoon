<?php 



/**
 * 
 * 
 * DEPRECATED!!!!
 * TODO: UPDATE TO WORK WITH UPDATED users AND watch_list TABLES
 * 
 * 
 */

require_once 'logInfo.php'; //pulls up data from logInfo.php
$conn = new mysqli($hn, $un, $pw, $db); //creates new mysqli object called conn with all the login info

if ($conn->connect_error) die($conn->connect_error); //if the data is wrong, then terminate and call the error



/**
 * so, we want to pull watchlist stock data, call an api for all the stock data together, 
 * and store that in a way that is accessible to html
 * user will have to be logged in for this. 
 */

$username = 'userName123'; //the username will be gotten from the login information

$userID = getUserID($username, $conn);
$watchList = getWatchList($userID, $conn);

/**
 * now, we call an ajax request to the URL 
 * https://api.worldtradingdata.com/api/v1/history_multi_single_day
 * but first we need to concatanate the strings of the watch list stocks together
 */

for ($i = 1; $i < count($watchList); $i++) {
 
    echo $watchList[$i] . '<br>';
    
    
}


/**
 * utilizes the username of the person to look up their userID from the userss table
 * @param unknown $username
 * @param unknown $conn
 * @return unknown
 */
function getUserID($username, $conn) {
    $query = "SELECT userID FROM users WHERE username = '$username'";
    $result = $conn -> query($query);
    
    if (!$result)   echo "INSERT failed: $query <br>" . $conn->error . "<br><br>";
    
    $result         -> data_seek(0);
    $userID         = $result -> fetch_array(MYSQLI_NUM);
    
    return $userID[0];
}


/**
 * Takes the userID from getUserID and gets the row for that ID in watch_list
 * @param unknown $userID
 * @param unknown $conn
 * @return unknown
 */
function getWatchList($userID, $conn) {
    
    $query = "SELECT * FROM watch_list WHERE userID = $userID";
    $result = $conn -> query($query);
    
    if (!$result)   echo "INSERT failed: $query <br>" . $conn->error . "<br><br>";
    
    $result         -> data_seek(0);
    
    return ($result -> fetch_array(MYSQLI_NUM));
    
}


?>