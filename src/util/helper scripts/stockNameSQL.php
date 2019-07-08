<?php 

/**
 * creates a table called stocks with columns: symbol, name, marketcap, IPOyear, sector, and industry
 * then, populates the table with the CSV files companylists off of nasdaq website
 */


require_once 'logInfo.php'; //pulls up data from logInfo.php
$conn = new mysqli($hn, $un, $pw, $db); //creates new mysqli object called conn with all the login info


if ($conn->connect_error) die($conn->connect_error); //if the data is wrong, then terminate and call the error

createTable($conn);
populateTable($conn);


function createTable($conn) {
    $tableName = "stocks";
    $query = "CREATE TABLE $tableName ( symbol CHAR(5), name VARCHAR(32), marketCap DOUBLE(16,2), sector VARCHAR(32), industry VARCHAR(32))";
    
    $result = $conn -> query($query);
    if (!$result)   echo "INSERT failed: $query <br>" . $conn->error . "<br><br>";
    
}


function populateTable($conn) {
    
    if (($file = fopen("companylist.csv", "r")) != FALSE) {
        
        while(($data = fgetcsv($file, 2000, ",")) != FALSE) {
            
            $data = fgetcsv($file, 2000, ",");
            $query = "INSERT INTO stocks(symbol, name, marketCap, sector, industry)" .
                     " VALUES('$data[0]', '$data[1]', $data[3], '$data[6]', '$data[7]')" ;
            
            $result = $conn -> query($query);
            if (!$result)   echo "INSERT failed: $query <br>" . $conn->error . "<br><br>";
               
        }
        fclose($file);
    }
}








?>