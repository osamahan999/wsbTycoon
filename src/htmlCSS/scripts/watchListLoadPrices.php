<?php 



/**
 * hard coded username. takes watchList data for said username and prints it. 
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

$username = 'testUser123'; //the username will be gotten from the login information

//gets watchList array and then prints it.
$watchList = getWatchList($username, $conn);
printWatchList($watchList, $conn);

/**
 * Takes the userID from getUserID and gets the row for that ID in watch_list
 * @param unknown $userID
 * @param unknown $conn
 * @return unknown
 */
function getWatchList($username, $conn) {
    
    $query = "SELECT watch_list1, watch_list2, watch_list3, watch_list4, watch_list5, watch_list6, watch_list7" . 
    ", watch_list8, watch_list9, watch_list10, watch_list11, watch_list12, watch_list13, watch_list14, " . 
    "watch_list15, watch_list16, watch_list17, watch_list18, watch_list19, watch_list20 FROM users WHERE username = '$username'";
    $result = $conn -> query($query);
    
    if (!$result)   echo "INSERT failed: $query <br>" . $conn->error . "<br><br>";
    
    $result         -> data_seek(0);
    
    return ($result -> fetch_array(MYSQLI_NUM));
    
}

function printWatchList($watchList, $conn) {
    $i = 0;
    while ($watchList[$i] != null) {
        echo $watchList[$i] . '<br>';
        $i++;
    }
}


?>