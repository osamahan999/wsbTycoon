<?php 

/**
 * the auto complete feature of our search bar, which searches all the stock symbols for similarities
 * also check out API 
 * https://www.worldtradingdata.com/documentation#searching
 */


require_once 'logInfo.php'; //pulls up data from logInfo.php
$conn = new mysqli($hn, $un, $pw, $db); //creates new mysqli object called conn with all the login info

if ($conn->connect_error) die($conn->connect_error); //if the data is wrong, then terminate and call the error


if ($_POST["search"]) {
    searchTable($_POST["search"]);
}

function searchTable($stock)  {
    // selects the symbol of the stock that has ap% in its symbol or name
    $query = "SELECT symbol FROM stocks WHERE (symbol LIKE 'ap%') OR (name LIKE 'ap%') LIMIT 5";
    $result = $conn -> query($query);
    
    $result         -> data_seek(0);
    $result         = $result -> fetch_array(MYSQLI_NUM);
    
    for ($i = 0; i < count($result); $i++) {
        echo $result[i] + '<br>';
    }
    
}







?>