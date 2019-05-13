<?php

/**
 this requires having the SQL server running, and the login file which
 contains the access to said SQL server. This is currently on my computer, so
 we wont be able to really do anything with this until we have a dedicated server.
 */

require_once 'login.php'; //pulls up data from login.php
$conn = new mysqli($hn, $un, $pw, $db); //creates new mysqli object called conn with all the login info
if ($conn->connect_error) die($conn->connect_error); //if the data is wrong, then terminate and call the error



if  (isset($_POST['username'])                           && //checks if theres input in username box
    (check_username_requirements($_POST['username']))          && //checks if username longer than 7 chars
    mysql_check_duplicate($conn, $_POST['username'])     && //checks if username is duplicate in database
    isset($_POST['password'])                            && 
    isset($_POST['email'])                               &&
    isset($_POST['fname'])                               &&
    isset($_POST['lname']))                                
{
    /**
     * sends query to server creating a new input into users table
     * 
     */
    $username       = mysql_entities_fix_string($conn, $_POST['username']);
    $password       = mysql_entities_fix_string($conn, hash_password($_POST['password']));
    $email          = mysql_entities_fix_string($conn, $_POST['email']);
    $fname          = mysql_entities_fix_string($conn, $_POST['fname']);
    $lname          = mysql_entities_fix_string($conn, $_POST['lname']);
    
    $query          = "INSERT INTO users VALUES" .
                    "('$username', '$password', '$email', '$fname', '$lname', '0')" ;
    
    $result         = $conn -> query($query);
    
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


//closes files
$conn -> close();



/**
 * does not work yet
 * Checks username to see if:
 * username > 7 characters
 * username contains uppercase letter
 * username contains number
 * @param unknown $string
 * @return boolean
 */
function check_username_requirements($string) {
    if ((strlen($string) > 7) && (1 === preg_match('~[0,9]~', $string)) && (1 === preg_match('/[A,Z]/', $string)))  {
        return true;
    }
    echo "Username is not longer than 7 characters, or does not contain an uppercase letter or number.";
    return false;
}



/**
 * checks if duplicate in database
 */
function mysql_check_duplicate($conn, $string) {
    
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
 * @param  $conn
 * @param  $string
 * @return string
 */
function mysql_entities_fix_string($conn, $string) {
    return htmlentities(mysql_fix_string($conn,$string));
}

function mysql_fix_string($conn, $string) {
    if (get_magic_quotes_gpc()) $string = stripslashes($string);
    return $conn -> real_escape_string($string);
}




?>
