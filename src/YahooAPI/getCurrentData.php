<?php 

require_once(__DIR__.'/../util/access/logInfo.php');
$conn = new mysqli($hn, $un, $pw, $db); //creates new mysqli object called conn with all the login info
if ($conn->connect_error) die($conn->connect_error); //if the data is wrong, then terminate and call the error

if (isset($_POST["stock"])) {
    $stock = mysql_entities_fix_string($conn, $_POST["stock"]); // user input with ajax
    
    getStockData($conn, $stock);
    
}


/**
 * First, generates yahoo finance page for input stock. 
 * Next, gets the file contents, strips it of html tags or any scripting exploits. 
 * Checks to see if yahoo does not have that stock; if not, returns false. 
 * Gets position of a globally found string in all yahoo finance stock pages
 * gets stock price & daily change & percentage in an estimated string
 * strips string into three separate sections and stores them
 * returns string with all info
 * 
 * @param unknown $conn
 * @param unknown $stock
 * @return boolean|string
 */
function getStockData($conn, $stock) {
    $yahooFile = "https://finance.yahoo.com/quote/$stock?p=$stock"; //main page
    
    $out = mysql_entities_fix_string($conn, strip_tags(file_get_contents($yahooFile)));
        

    
    if (strpos($out, "All (0)Stocks (0)Mutual Funds (0)ETFs (0)Indices (0)Futures (0)Currencies (0)No results for") !== false) return false;
    
    $pos = strpos($out, "trend2W10W9M");
    $out = substr($out, $pos + 12, 26);
    
    $stockData = Array();
    
    /**
     * sample string 1,258.41+46.25 (+3.82%)At
     * split by +, by first parantheses, and by last one.
     */
    
    $i = 1;
    $char = $out[$i];
    $currentPrice = $out[0];
    while (strcmp($char, "+") != 0 && strcmp($char, "-") != 0) {
        $currentPrice = $currentPrice . $char;
        $i++;
        $char = $out[$i];
    }
    
    $posOrNeg = $char;
    $stockData[3] = $posOrNeg;
    
    $stockData[0] = $currentPrice;
    
    
    $i = strlen($currentPrice) + 2; //adds the + and the first two char
    $char = $out[$i]; //second char
    $amtUp = $out[$i - 1];
    
    while (strcmp($char, ' ') != 0) {
        $amtUp = $amtUp . $char;
        $i++;
        $char = $out[$i];
    }
    
    $stockData[1] = $amtUp;
    
    
    $i = strlen($currentPrice) + strlen($amtUp) + 5; //starts after (+ and first num
    $char = $out[$i];
    $percentUp = $out[$i - 1];
    
    
    while (strcmp($char, '%') != 0) {
        $percentUp = $percentUp . $char;
        $i++;
        $char = $out[$i];
    }
    
    $stockData[2] = $percentUp;
    
    echo json_encode(array("price" => $stockData[0], "amt" => $stockData[1], "percent" => $stockData[2], "posOrNeg" => $stockData[3]));
}


function mysql_entities_fix_string($conn, $string) {
    return htmlentities(mysql_fix_string($conn, $string));
}

function mysql_fix_string($conn, $string) {
    
    if (get_magic_quotes_gpc()) $string = stripslashes($string);
    return $conn -> real_escape_string($string);
}

?>