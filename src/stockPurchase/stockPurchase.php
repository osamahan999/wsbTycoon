<?php 

/**
 * ask about globals and about incrementing in for loops
 * 
 * 
 * 
 */

require(__DIR__.'/../util/access/logInfo.php');
$conn = new mysqli($hn, $un, $pw, $db); //creates new mysqli object called conn with all the login info
if ($conn->connect_error) die($conn->connect_error); //if the data is wrong, then terminate and call the error


//hard coded transaction type for now
$transactionType = 'buy';


if ($_POST) {
    
    $stock = mysql_entities_fix_string($conn, $_POST['myStock']);
    $amt = mysql_entities_fix_string($conn, $_POST['amt']);
    $username = mysql_entities_fix_string($conn, $_POST['username']);
    
    purchaseStock($stock, $amt, $username, $transactionType, $conn);
}



function purchaseStock ($stock, $amt, $username, $transactionType, $conn) {
    
    $userID = getUserID($username, $conn);
    
    //displays DATETIME values in 'YYYY-MM-DD hh:mm:ss'
    $currentTime = currentDate();
    
    $dateTime = "2019-08-01 20:24:03";
    
    $stockPrice = getStockPrice($stock, $dateTime, $conn);
    $stockPrice *= $amt;
    
    $userCash = getUserCash($userID, $conn);
    
    if ($stockPrice > $userCash) {
        echo "You are far too broke for this buddy";
    } else {
        //gets new cash
        $newCash = $userCash - $stockPrice;
        //updates the user's cash
        $query = "UPDATE users SET totalMoney = '$newCash' WHERE userID = '$userID'";
        $result = $conn -> query($query);
        
        
        updateTransactionsTable($stock, $transactionType, $amt, $dateTime, $userID);
        if (!$result) echo "UPDATE FAILED " . $query;
        
        
    }
    
}

//gets the specific user's totalMoney
function getUserCash($userID, $conn) {
    
    $query = "SELECT totalMoney FROM users WHERE userID = '$userID'";
    $result = $conn -> query($query);
    
    if (!$result) echo "QUERY FAILED" . $query;
    
    $result -> num_rows;
    $userCash = $result -> fetch_array(MYSQLI_NUM);
    
    return $userCash[0];
}

//adds the new purchase onto the transactions table;
function updateTransactionsTable($stock, $transactionType, $amt, $date, $userID) {
    
    $query = "INSERT INTO transactions(stockSymbol, transactionType, amtTraded, tradeDate, userID) VALUES" .
             "('$stock', 'buy', '$amt', '$date', '$userID')";
    $result = $conn -> query($query);
    
    if (!$result) echo "INSERT FAILED " . $query;
}

//gets the user'd userid using their username. makes further searches quicker
function getUserID($username, $conn) {
    
    $query = "SELECT userID FROM users WHERE username = '$username'";
    $result = $conn -> query($query);
    
    $result -> num_rows;
    $userID = $result -> fetch_array(MYSQLI_NUM);
    
    return $userID[0];
}

// gets the stock's price in our stockPrice table
function getStockPrice ($stock, $currentTime, $conn) {
    
    $query = "SELECT price FROM stockPrices WHERE stock = '$stock' AND timeOfPrice = '$currentTime'";
    $result = $conn -> query($query);
    
    $result -> num_rows;
    $stockPrice = $result -> fetch_array(MYSQLI_NUM);
    
    return $stockPrice[0];
}

//change it to be global date time
function currentDate() {
    $currentDateTime = date("Y:m:d H:i:s");

    return $currentDateTime;
}

/**
 * fixes string to not get breached
 * @param  $string
 * @return string
 */
function mysql_entities_fix_string($conn, $string) {
    return htmlentities(mysql_fix_string($string));
}

function mysql_fix_string($conn, $string) {
    if (get_magic_quotes_gpc()) $string = stripslashes($string);
    return $conn -> real_escape_string($string);
}


?>