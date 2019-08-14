<?php 
session_start();

require(__DIR__.'/../util/access/logInfo.php');
$conn = new mysqli($hn, $un, $pw, $db); //creates new mysqli object called conn with all the login info
if ($conn->connect_error) die($conn->connect_error); //if the data is wrong, then terminate and call the error


if ($_POST['logIn']) {
    console.log("logIn called");
    logIn();
}
if ($_POST['getMoney']) getMoney();



function logIn() {
    if (isset($_SESSION['userID'])) {
        
        echo json_encode(array("isLogged" => true));
    } else {
        echo json_encode(array("isLogged" => false));
    }
}

function getMoney() {
    $userID = $_SESSION['userID'];
    
    $query = "SELECT totalMoney FROM users WHERE userID = $userID";
    $result = $conn -> query($query);
    $result         -> data_seek(0);
    $result         = $result -> fetch_array(MYSQLI_NUM);
    
    echo json_encode(array("totalMoney" => $result[0]));
}



?>