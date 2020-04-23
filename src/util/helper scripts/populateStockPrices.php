<?php 


require_once '/../access/logInfo.php'; //pulls up data from logInfo.php
$conn = new mysqli($hn, $un, $pw, $db); //creates new mysqli object called conn with all the login info


if ($conn->connect_error) die($conn->connect_error); //if the data is wrong, then terminate and call the error
$csv1 = '../csv files/companylistNYSE8132019.csv';
$csv2 = '../csv files/companylistNASDAQ8132019.csv';
$csv3 = '../csv files/companylistAMEX8132019.csv';


// populateTable($conn, $csv1);
populateTable($conn, $csv2);
// populateTable($conn, $csv3);

function populateTable($conn, $csv) {
    
    if (($file = fopen($csv, "r")) != FALSE) {
        
        ini_set('max_execution_time', 600); //temporarily sets max exe time to 300 if computer is slow at adding records to table.
        while(($data = fgetcsv($file, 2000, ",")) != FALSE) {
            
            $query = "SELECT stockID FROM stocks WHERE symbol='$data[0]'";
            $result = $conn -> query($query);
            
            if (!$result)   echo "SELECT failed: $query <br>" . $conn->error . "<br><br>";
            
            $result -> data_seek[0];
            $row = $result -> fetch_array(MYSQLI_NUM);
            $id = $row[0];
            
            //date hardcoded for now
            $query = "INSERT INTO stockPrices(stock, timeOfPrice, price, stockID)" .
                " VALUES('$data[0]', '2019-08-13 23:40:50', $data[2], '$id')" ;
            
            $result = $conn -> query($query);
            if (!$result)   echo "INSERT failed: $query <br>" . $conn->error . "<br><br>";
            
        }
        fclose($file);
    }
}





?>