<?php 

require(__DIR__.'/../util/access/logInfo.php');
$conn = new mysqli($hn, $un, $pw, $db); //creates new mysqli object called conn with all the login info
if ($conn->connect_error) die($conn->connect_error); //if the data is wrong, then terminate and call the error

$stock = mysql_entities_fix_string($conn, $_GET["stock"]); // user input with ajax


getStockData($stock);




function getStockData($stock) {
    $yahooFile = "https://finance.yahoo.com/quote/$stock?p=$stock"; //main page
    
    $out = strip_tags(file_get_contents($yahooFile));
        
    $pos = strpos($out, "trend2W10W9M");
    
    
    $out = substr($out, $pos + 12, 26);
    
    
    /**
     * sample string 1,258.41+46.25 (+3.82%)At
     * split by +, by first parantheses, and by last one.
     */
    
    $i = 1;
    $char = $out[$i];
    $currentPrice = $out[0] + "";
    while (strcmp($char, "+") != 0) {
        $currentPrice = $currentPrice . $char;
        $i++;
        $char = $out[$i];
    }
    
    
    $i = strlen($currentPrice) + 2; //adds the + and the first two char
    
    $char = $out[$i]; //second char
    $amtUp = $out[$i - 1];
    
    while (strcmp($char, ' ') != 0) {
        $amtUp = $amtUp . $char;
        $i++;
        $char = $out[$i];
    }
    
    $i = strlen($currentPrice) + strlen($amtUp) + 5; //starts after (+ and first num
    $char = $out[$i];
    $percentUp = $out[$i - 1];
    
    
    while (strcmp($char, '%') != 0) {
        $percentUp = $percentUp . $char;
        $i++;
        $char = $out[$i];
    }
    
    echo "$stock price is $currentPrice, going up $amtUp today, which is $percentUp%";
}


function mysql_entities_fix_string($conn, $string) {
    return htmlentities(mysql_fix_string($conn, $string));
}

function mysql_fix_string($conn, $string) {
    
    if (get_magic_quotes_gpc()) $string = stripslashes($string);
    return $conn -> real_escape_string($string);
}

?>