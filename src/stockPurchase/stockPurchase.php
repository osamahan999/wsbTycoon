<?php 

require(__DIR__.'/../util/access/logInfo.php');
$conn = new mysqli($hn, $un, $pw, $db); //creates new mysqli object called conn with all the login info
if ($conn->connect_error) die($conn->connect_error); //if the data is wrong, then terminate and call the error



function purchaseStock ($stock, $amt, $username) {
    global $conn;
    
    $userID = getUserID($username);
    //displays DATETIME values in 'YYYY-MM-DD hh:mm:ss'
    $currentTime = currentDate();
    
    $stockPrice = getStockPrice($stock, $currentTime);
    $stockPrice *= $amt;
    
    $userCash = getUserCash($userID);
    
    if ($stockPrice > $userCash) {
        echo "You are far too broke for this buddy";
    } else {
        //gets new cash
        $newCash = $userCash - $stockPrice;
        //updates the user's cash
        $query = "UPDATE users SET totalMoney = '$newCash' WHERE userID = '$userID'";
        $result = $conn -> query($query);
        
        if (!$result) echo "UPDATE FAILED " . $query;
        
        
    }
    
}

//gets the specific user's totalMoney
function getUserCash($userID) {
    global $conn;
    
    $query = "SELECT totalMoney FROM users WHERE userID = '$userID'";
    $result = $conn -> query($query);
    
    if (!$result) echo "QUERY FAILED" . $query;
}

//adds the new purchase onto the transactions table;
function updateTransactionsTable() {
    global $conn;
    
    $query = "INSERT INTO transactions(stockSymbol, transactionType, amtTraded, tradeDate, userID) VALUES" .
             "('$stock', 'buy', '$amt', '$currentTime', '$userID')";
    $result = $conn -> query($query);
    
    if (!$result) echo "INSERT FAILED " . $query;
}

//gets the user'd userid using their username. makes further searches quicker
function getUserID($username) {
    global $conn;
    
    $query = "SELECT userID FROM users WHERE username = '$username'";
    $result = $conn -> query($query);
    
    $result -> num_rows;
    $userID = $result -> fetch_array(MYSQLI_NUM);
    
    return $userID;
}

// gets the stock's price in our stockPrice table
function getStockPrice ($stock, $currentTime) {
    global $conn;
    
    $query = "SELECT price FROM stockPrices WHERE stock = $stock AND timeOfPrice = $currentTime";
    $result = $conn -> query($query);
}

//change it to be global date time
function currentDate() {
    $currentDateTime = date("Y:m:d H:i:s");

    return $currentDateTime;
}


?>