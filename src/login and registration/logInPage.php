<?php
session_start();

require(__DIR__.'/../util/access/logInfo.php');
$conn = new mysqli($hn, $un, $pw, $db); //creates new mysqli object called conn with all the login info
if ($conn->connect_error) die($conn->connect_error); //if the data is wrong, then terminate and call the error

$logged_in = false;


/**
 * checks to see if all the indeces are set
 * if they are, then it sets all the variables to equal
 * the getpost thing must always be used to make sure data is safe before sending it as a query to a database
 * sets query to be equal to the string for inserting new values
 * then sends the query and stores output in result
 * if the output is false, we output error message
 */
if (isset($_POST['username'])       &&
    isset($_POST['password']))       
{
    
    
    
    $username       = mysql_entities_fix_string($conn, $_POST['username']);
    $password       = mysql_entities_fix_string($conn, $_POST['password']);

    log_in($username, $password);
}



function log_in($username, $password) {
    global $conn;
    
    $query          = "SELECT * FROM users WHERE username LIKE '$username'";
    $result         = $conn -> query($query);
    $result         -> data_seek(0);
    $result         = $result -> fetch_array(MYSQLI_NUM);
    
    if (password_verify($password, $result[2])) {
        
        $logged_in = true;
        $_SESSION['userID'] = $result[0];
        
        echo json_encode(array("isLogged" => $logged_in, "userID" => $_SESSION['userID']));
        
    } else {
        $logged_in = false;
        echo json_encode(array("isLogged" => $logged_in));
    }
}

function hash_password($string) {
    return password_hash($string, PASSWORD_DEFAULT);
}

//checks data before sending query

function mysql_entities_fix_string($conn, $string) {
    return htmlentities(mysql_fix_string($conn,$string));
}

function mysql_fix_string($conn, $string) {
    if (get_magic_quotes_gpc()) $string = stripslashes($string);
    return $conn -> real_escape_string($string);
}




?>