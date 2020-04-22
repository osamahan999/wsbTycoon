<?php 

/**
 * creates a table called stocks with columns: symbol, name, marketcap, IPOyear, sector, and industry
 * then, populates the table with the CSV files companylists off of nasdaq website
 */


require '/../access/logInfo.php'; //pulls up data from logInfo.php
$conn = new mysqli($hn, $un, $pw, $db); //creates new mysqli object called conn with all the login info


if ($conn->connect_error) die($conn->connect_error); //if the data is wrong, then terminate and call the error

$csv = '../csv files/companylistNYSE8122019.csv';

// createTable($conn);
populateTable($conn, $csv);


function createTable($conn) {
    $tableName = "stocks";
    $query = "CREATE TABLE $tableName (stockID INT(5) NOT NULL AUTO_INCREMENT KEY, symbol CHAR(5), name VARCHAR(32), marketCap DOUBLE(16,2), sector VARCHAR(32), industry VARCHAR(32))";
    
    $result = $conn -> query($query);
    if (!$result)   echo "INSERT failed: $query <br>" . $conn->error . "<br><br>";
    
}


function populateTable($conn, $csv) {
    
    if (($file = fopen($csv, "r")) != FALSE) {
        
        ini_set('max_execution_time', 600); //temporarily sets max exe time to 300 if computer is slow at adding records to table.
        while(($data = fgetcsv($file, 2000, ",")) != FALSE) {
            
            $query = "INSERT INTO stocks(symbol, name, marketCap, sector, industry)" .
                     " VALUES('$data[0]', '$data[1]', $data[3], '$data[6]', '$data[7]')" ;
            
            $result = $conn -> query($query);
            if (!$result)   echo "INSERT failed: $query <br>" . $conn->error . "<br><br>";
               
        }
        fclose($file);
    }
}








?>