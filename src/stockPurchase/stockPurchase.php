<?php 

require(__DIR__.'/../util/access/logInfo.php');
$conn = new mysqli($hn, $un, $pw, $db); //creates new mysqli object called conn with all the login info
if ($conn->connect_error) die($conn->connect_error); //if the data is wrong, then terminate and call the error

// get username




function getUserCash($username) {
    global $conn;
    
    $query = "SELECT cash FROM users WHERE username = '$username'";
    $result = $conn -> query($query);
    
    
}



?>