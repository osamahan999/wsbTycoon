<?php

/**
 this requires having the SQL server running, and the login file which
 contains the access to said SQL server. This is currently on my computer, so
 we wont be able to really do anything with this until we have a dedicated server.
 */


require(__DIR__.'/../util/access/logInfo.php');
$conn = new mysqli($hn, $un, $pw, $db); //creates new mysqli object called conn with all the login info
if ($conn->connect_error) die($conn->connect_error); //if the data is wrong, then terminate and call the error


//default values
$defaultTotalMoney = 100000;
$defaultRevenue = 0;
$defaultLoss = 0;
$userID = 0;
$defaultWatchList = array ("'MSFT'", "'TSLA'", "'GOOGL'", "'AAPL'", "'NVDA'", "'AMD'", "'FB'", "'X'", "'GPRO'", "'DIS'");





/**
 * checks if there are inputs in the input html
 * break the DRY principal here but like its the registration page, so who cares. 
 */
if  (isset($_POST['username'])                                                                         && //checks if theres input in username box
    mysql_check_duplicate(mysql_entities_fix_string($conn, $_POST['username']), $conn)                 && //checks if username is duplicate in database
    isset($_POST['password'])                                                                          &&
    check_password_requirements(mysql_entities_fix_string($conn, $_POST['password']), $conn)           && 
    isset($_POST['email'])                                                                             &&
    isset($_POST['fname'])                                                                             &&
    isset($_POST['lname']))                                
{
    /**
     * sanitizes strings and creates user-table and watch_list-table inputs
     */
    $username       = mysql_entities_fix_string($conn, $_POST['username']);
    $password       = hash_password(mysql_entities_fix_string($conn, $_POST['password']));
    $email          = mysql_entities_fix_string($conn, $_POST['email']);
    $firstName      = mysql_entities_fix_string($conn, $_POST['fname']);
    $lastName       = mysql_entities_fix_string($conn, $_POST['lname']);
    
    
    initializeTables($username, $password, $email, $firstName, $lastName, $defaultWatchList, $conn);
    
}

/**
 * creates new user, and puts them in users table and in watch_list tables with default input
 * @param unknown $username
 * @param unknown $password
 * @param unknown $email
 * @param unknown $firstName
 * @param unknown $lastName
 * @param unknown $defaultWatchList
 * @param unknown $conn
 */
function initializeTables($username, $password, $email, $firstName, $lastName, $defaultWatchList, $conn) {
//     $query          = "INSERT INTO users VALUES" .
//                       "('$userID', '$username', '$password', '$email', '$firstName', '$lastName', '$defaultTotalMoney', '$defaultRevenue'," . 
//  "'$defaultLoss', '$defaultWatchList[0]', '$defaultWatchList[1]', '$defaultWatchList[2]', '$defaultWatchList[3]', '$defaultWatchList[4]', '$defaultWatchList[5]'," . 
//     "'$defaultWatchList[6]', '$defaultWatchList[7]', '$defaultWatchList[8]', '$defaultWatchList[9]', '$defaultWatchList[10]','','','','','','','','','','')" ;
    
//     $result         = $conn -> query($query);

    
    $query = <<<_query
        "INSERT INTO users (userID, username, password, email, firstName, lastName, totalMoney, 
        revenue, loss, watch_list1, watch_list2, watch_list3, watch_list4, watch_list5, watch_list6, 
        watch_list7, watch_list8, watch_list9, watch_list10) VALUES "('$userID', '$username', 
        '$password', '$email', '$firstName', '$lastName', '$defaultTotalMoney', '$defaultRevenue', 
        '$defaultLoss', $defaultWatchList[0], $defaultWatchList[1], $defaultWatchList[2], $defaultWatchList[3], 
        $defaultWatchList[4], $defaultWatchList[5], $defaultWatchList[6], $defaultWatchList[7], 
        $defaultWatchList[8], $defaultWatchList[9])"
_query;
    $result = $conn -> query($query);
    
    if (!$result)   echo "INSERT failed: $query <br>" . $conn->error . "<br><br>";
    
}



/** 
 * we use the echo with label to exit PHP and write some html code
 * here we build our new user button and all the fields
 * all buttons are required
 */
echo <<<_END
<form action    = "wsbRegister.php" method = "post"><pre>
    username:   <input type = "text" name = "username"  required>
    password:   <input type = "text" name = "password"  required>
    email:      <input type = "text" name = "email"     required>
    first name: <input type = "text" name = "fname"     required>
    last name:  <input type = "text" name = "lname"     required>     
                <input type = "submit" value = "CREATE NEW USER">
</pre></form>
_END;




/**
 * doesnt work yet
 * Checks username to see if:
 * username contains uppercase letter
 * username contains number
 * @param unknown $string
 * @return boolean
 */
function check_password_requirements($string, $conn) {
    if (preg_match('/\d/', $string) && preg_match( '/[A-Z]/', $string)) {
        return true;
    }
    echo "Password is not longer than 7 characters, or does not contain an uppercase letter or number.";
    return false;
}



/**
 * checks if duplicate in database
 */
function mysql_check_duplicate($string, $conn) {
    $query          = "SELECT email FROM users WHERE username LIKE '$string'";
    $result         = $conn -> query($query);
    
    if (!mysqli_num_rows($result)==0) {
        ECHO "Duplicate username! Please try a different one.";
        return false;
    }
    return true;
    
}

/**
 * hashes password with default algorithm
 * @param  $string
 * @return string
 */
function hash_password($string) {
    return password_hash($string, PASSWORD_DEFAULT);
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



//closes files
$conn -> close();

?>
