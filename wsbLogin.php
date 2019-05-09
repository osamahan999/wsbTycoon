<?php

require_once 'login.php'; //pulls up data from login.php
$conn = new mysqli($hn, $un, $pw, $db); //creates new mysqli object called conn with all the login info
if ($conn->connect_error) die($conn->connect_error); //if the data is wrong, then terminate and call the error





/**
 * checks to see if all the indeces are set
 * if they are, then it sets all the variables to equal
 * the getpost thing must always be used to make sure data is safe before sending it as a query to a database
 * sets query to be equal to the string for inserting new values
 * then sends the query and stores output in result
 * if the output is false, we output error message
 */
if (isset($_POST['username'])   && mysql_check_duplicate($conn, $_POST['username']) &&
    isset($_POST['password'])    &&
    isset($_POST['email']))
{
    
    $username       = mysql_entities_fix_string($conn, $_POST['username']);
    $password       = mysql_entities_fix_string($conn, hash_password($_POST['password']));
    $email          = mysql_entities_fix_string($conn, $_POST['email']);
    $query          = "INSERT INTO users VALUES" .
        "('$username', '$password', '$email', '0')" ;
    
    $result         = $conn -> query($query);
    
    if (!$result) echo "INSERT failed: $query <br>" . $conn->error . "<br><br>";
}



/**
 * we use the echo with label to exit PHP and write some html code
 * here we build our new user button and all the fields
 */
echo <<<_END
<form action = "wallstreetLogin.php" method = "post"><pre>
  username:     <input type = "text" name = "username">
  password:     <input type = "text" name = "password">
  email:        <input type = "text" name = "email">
                <input type = "submit" value = "CREATE NEW USER">
</pre></form>
_END;


//closes files
//     $result -> close();
$conn -> close();


//checks for duplicate username ONLY
function mysql_check_duplicate($conn, $string) {
    
    $query          = "SELECT email FROM users WHERE username LIKE '$string'";
    $result         = $conn -> query($query);
    
    if (!mysqli_num_rows($result)==0) {
        ECHO "Duplicate username! Please try a different one.";
        return false;
    }
    return true;
    
}

function hash_password($string) {
    return password_hash($string, PASSWORD_DEFAULT);
}

//checks data before sending query

function mysql_entities_fix_string($conn, $string) {
    return htmlentities(mysql_fix_string($conn,$string));
}

function mysql_fix_string($conn, $string) {
    if (get_magic_quotes_gpc()) $string = stripslashes($string);
    return $conn -> real_escape_string($string);
}




?>
