<?php 

require_once(__DIR__.'/../util/access/logInfo.php');
$conn = new mysqli($hn, $un, $pw, $db); //creates new mysqli object called conn with all the login info
if ($conn->connect_error) die($conn->connect_error); //if the data is wrong, then terminate and call the error




if (isset($_POST[stock]) && isset($_POST[amt]) && isset($_POST[price]) && isset($_POST[username])) {
    
    $stock = mysql_entities_fix_string($conn, $_POST[stock]);
    $amt = mysql_entities_fix_string($conn, $_POST[amt]);
    $price = mysql_entities_fix_string($conn, $_POST[price]);
    $username = mysql_entities_fix_string($conn, $_POST[username]);
    $purchaseType = mysql_entities_fix_string($conn, $_POST[purchaseType]);
    
    
    if (strcmp($purchaseType, 'buy') == 0) purchase($conn, $stock, $amt, $price, $username); //if buy, call purchase
}

//if not set, break; 
//get owned shares of this stock
if (isset($_POST[action]) && strcmp(mysql_entities_fix_string($conn, $_POST[action]), "getOwned") == 0) {
    
    $username = mysql_entities_fix_string($conn, $_POST[username]);
    $stock = mysql_entities_fix_string($conn, $_POST[stock]);
    
    getOwned($conn, $username, $stock);
}


function getOwned($conn, $username, $stock) {
    
    $query = "SELECT * FROM transactions WHERE userID = (SELECT userID FROM users WHERE username='$username') AND stockSymbol='$stock'";
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


/**
 * Deduces amt of cash necessary from your user cash, and adds the transaction to the transactions page.
 * @param unknown $conn
 * @param unknown $stock
 * @param unknown $amt
 * @param unknown $price
 * @param unknown $username
 */
function purchase($conn, $stock, $amt, $price, $username) {
    
    if (addTransaction($conn, $stock, $amt, $price, $username)) {
        
        $totalCost = $amt * $price; //total cost of the purchase
        $query = "UPDATE users SET totalMoney=(totalMoney - $totalCost) WHERE username='$username'"; //updates your cash
        
        /**
         * If this update works, only then can we add this to the transactions. Don't want to give someone stocks for free!!
         * @var unknown $result
         */
        $result = $conn -> query($query);
        if (!$result)     echo json_encode(array(successful => false));
        else echo json_encode(array(successful => true));
    }
}

function addTransaction($conn, $stock, $amt, $price, $username) {
    $queryInsertParams = "INSERT INTO transactions (stockSymbol, transactionType, price, amtTraded, tradeDate, userID)";
    $dateQuery = "(SELECT CURRENT_TIMESTAMP())"; //gets server timestamp
    $userIDQuery = "(SELECT userID FROM users WHERE username='$username')"; //gets userID of the user
    $query =  "$queryInsertParams" . " VALUES ('$stock', 'buy', '$price', '$amt', $dateQuery, $userIDQuery)";
    
    $result = $conn -> query($query);
    if (!$result) return false;
    else {
        return true;
    }
}

function mysql_entities_fix_string($conn, $string) {
    return htmlentities(mysql_fix_string($conn, $string));
}

function mysql_fix_string($conn, $string) {
    
    if (get_magic_quotes_gpc()) $string = stripslashes($string);
    return $conn -> real_escape_string($string);
}


?>