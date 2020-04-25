<?php 
session_start();

require_once(__DIR__.'/../util/access/logInfo.php');
$conn = new mysqli($hn, $un, $pw, $db); //creates new mysqli object called conn with all the login info

if ($conn->connect_error) die($conn->connect_error); //if the data is wrong, then terminate and call the error

$actionAjax = mysql_entities_fix_String($conn, $_POST['action']); 

if ($actionAjax == "logIn") {
    logIn($conn);
}
if ($actionAjax == "getTotalMoneyAndUserID") {
    getTotalMoneyAndUserID($conn);
}


//if not set, break;
//get owned shares of this stock
if (isset($_POST[action]) && strcmp(mysql_entities_fix_string($conn, $_POST[action]), "getOwned") == 0) {
    
    $username = mysql_entities_fix_string($conn, $_POST[username]);
    
    getOwned($conn, $username, $stock);
}


function getOwned($conn, $username) {
    
    $query = "SELECT * FROM transactions WHERE userID = (SELECT userID FROM users WHERE username='$username')";
    $result         = $conn -> query($query);
    
    $ownedStocks = array();
    $length = $result -> num_rows;
    
    
    for ($i = 0; $i < $length; $i++) {
        $row    = $result   -> data_seek[i];
        $newResult = $result   -> fetch_array(MYSQLI_NUM);
        
        array_push($ownedStocks, $newResult);
        
    }
    
    echo json_encode(array(result => $ownedStocks));
    
    
}



function logIn($conn) {
    if ((mysql_entities_fix_string($conn, $_SESSION['userID'])) !== null) {
        
        echo json_encode(array("isLogged" => true));
    } else {
        echo json_encode(array("isLogged" => false));
    }
}

function getTotalMoneyAndUserID($conn) {
    $userID = $_SESSION['userID'];
    
    $query = "SELECT totalMoney,username FROM users WHERE userID = $userID";
    $result = $conn -> query($query);
    
    $result         -> data_seek(0);
    $result         = $result -> fetch_array(MYSQLI_NUM);
    
    echo json_encode(array("totalMoney" => $result[0], "username" => $result[1]));
}

function mysql_entities_fix_string($conn, $string) {
    return htmlentities(mysql_fix_string($conn, $string));
}

function mysql_fix_string($conn, $string) {
    
    if (get_magic_quotes_gpc()) $string = stripslashes($string);
    return $conn -> real_escape_string($string);
}


?>