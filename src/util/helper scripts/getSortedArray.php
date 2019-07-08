<?php 

require_once('logInfo.php');

$conn = new mysqli($hn, $un, $pw, $db); //creates new mysqli object called conn with all the login info
if ($conn->connect_error) die($conn->connect_error); //if the data is wrong, then terminate and call the error

createArray($conn);

function createArray($conn) {
    $query = "SELECT symbol,name FROM stocks ORDER BY symbol"; //gets symbol,name in alphabetical symbol order
    
    $result = $conn -> query($query);
    
    $stockArray = array();
    
    
    for ($i = 0; $i < $result -> num_rows; $i++) {
        $newResult = $result   -> fetch_array(MYSQLI_NUM);
        $stockArray[$i] = array("$newResult[0]", "$newResult[1]");
//         echo $stockArray[$i][0] . ", " . $stockArray[$i][1] . '<br>';
    }
    
    //prints out array in javascript notation. NOTE!!!! last element has a comma after it that you should delete. 
    echo "var arr = [";
    for ($i = 0; $i < sizeof($stockArray); $i++) {
        echo ' ["' . $stockArray[$i][0] . '", "' . $stockArray[$i][1] . '" ],';
    }
    echo "];";
}



?>