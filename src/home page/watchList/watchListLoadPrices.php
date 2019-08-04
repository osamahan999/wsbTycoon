<?php 


require(__DIR__.'/../../util/access/logInfo.php');
$conn = new mysqli($hn, $un, $pw, $db); //creates new mysqli object called conn with all the login info

if ($conn->connect_error) die($conn->connect_error); //if the data is wrong, then terminate and call the error



if (isset($_GET['input'])) {
    getWatchList($_GET['input']);
}

/**
 * Takes the userID from getUserID and gets the row for that ID in watch_list
 * @param unknown $userID
 * @param unknown $conn
 * @return unknown
 */
function getWatchList($username) {
    
    global $conn;
        
    $query = "SELECT watch_list1, watch_list2, watch_list3, watch_list4, watch_list5, watch_list6, watch_list7" . 
    ", watch_list8, watch_list9, watch_list10, watch_list11, watch_list12, watch_list13, watch_list14, " . 
    "watch_list15, watch_list16, watch_list17, watch_list18, watch_list19, watch_list20 FROM users WHERE username = '$username'";
    $result = $conn -> query($query);
    
    if (!$result)   echo "INSERT failed: $query <br>" . $conn->error . "<br><br>";
    
    $result         -> data_seek(0);
    $watchList = $result -> fetch_array(MYSQLI_NUM);
    
    echo json_encode(array("watchList" => $watchList));
}



//just if i want to print the watchlist
function printWatchList($watchList) {
    global $conn;
    
    $i = 0;
    while ($watchList[$i] != null) {
        echo $watchList[$i] . '<br>';
        $i++;
    }
}


?>