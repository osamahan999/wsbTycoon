<?php 

// log in
// get username




function getUserCash($username) {
    global $conn;
    
    $query = "SELECT cash FROM users WHERE username = '$username'";
    $result = $conn -> query($query);
    
    
}



?>