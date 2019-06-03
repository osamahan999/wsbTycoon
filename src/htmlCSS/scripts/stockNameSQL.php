<?php 

/**
 * creates a table called stocks with columns: symbol, name, marketcap, IPOyear, sector, and industry
 * then, populates the table with the CSV files companylists off of nasdaq website
 */


require_once 'logInfo.php'; //pulls up data from logInfo.php
$conn = new mysqli($hn, $un, $pw, $db); //creates new mysqli object called conn with all the login info

if ($conn->connect_error) die($conn->connect_error); //if the data is wrong, then terminate and call the error

createTable();
populateTable();


function createTable() {
    $tableName = "stocks";
    $query = "CREATE TABLE $tableName (" .
                    "Symbol CHAR(5)," .
                    "Name VARCHAR(32)," .
                    "MarketCap DOUBLE(16,2)," .
                    "IPOyear INT(4)," .
                    "Sector VARCHAR(32)," .
                    "Industry VARCHAR(32)" . 
                    ")";
    
    $result = $conn -> query($query);
    if (!$result)   echo "INSERT failed: $query <br>" . $conn->error . "<br><br>";
    
}


function populateTable() {
    
    if (($file = fopen("companylist.csv", "r")) != FALSE) {
        
        while(($data = fgetcsv($file, 2000, ",")) != FALSE) {
            
            $query = "INSERT INTO stocks(Symbol, Name, MarketCap, IPOyear, Sector, Industry)" .
                     "VALUES($data[0], $data[1], $data[3], $data[5], $data[6], $data[7])" ;
            
            $result = $conn -> query($query);
            if (!$result)   echo "INSERT failed: $query <br>" . $conn->error . "<br><br>";
               
        }
        fclose($file);
    }
}








?>