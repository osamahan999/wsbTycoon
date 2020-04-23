<?php
/**
 * the auto complete feature of our search bar, which searches all the stock symbols for similarities
 * utilizes sql table 'stocks' rather than the api. this reduces our ajax requests.
 */

require(__DIR__.'/../../util/access/logInfo.php');
$conn = new mysqli($hn, $un, $pw, $db); //creates new mysqli object called conn with all the login info
if ($conn->connect_error) die($conn->connect_error); //if the data is wrong, then terminate and call the error






if (isset($_POST['input'])) {
    searchTable(mysql_entities_fix_string($conn, $_POST['input']), $conn);
}




/**
 * pulls up 5 top matches. puts them in array $pulledStocks
 * @param unknown $stock
 * @param unknown $conn
 */
function searchTable($stock, $conn)  {
    
    
    //limit amount set in query
    $limit = 5;
    
    // selects the symbol of the stock that has ap% in its symbol or name
    $query = "SELECT symbol FROM stocks WHERE (symbol LIKE '$stock%') OR (name LIKE '$stock%') ORDER BY symbol LIMIT $limit";
    $result = $conn -> query($query);
    
    $pulledStocks = array();
    
    for ($i = 0; $i < $limit; $i++) {
        $row    = $result   -> data_seek[i];
        $newResult = $result   -> fetch_array(MYSQLI_NUM);
        
        array_push($pulledStocks, $newResult[0]);
        
    }
        
    echo json_encode(array("TopFiveStocks"=>$pulledStocks));
}

function mysql_entities_fix_string($conn, $string) {
    return htmlentities(mysql_fix_string($conn, $string));
}

function mysql_fix_string($conn, $string) {
    
    if (get_magic_quotes_gpc()) $string = stripslashes($string);
    return $conn -> real_escape_string($string);
}
?>