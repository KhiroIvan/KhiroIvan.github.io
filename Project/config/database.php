<?php
// used to connect to the database
$host = "localhost";
$db_name = "ivantan";
$username = "ivantan";
$password = ")CCtN1*zV2dMuehp";
  
try {
    $con = new PDO("mysql:host={$host};dbname={$db_name}", $username, $password);
    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
     
}
  
// show error
catch(PDOException $exception){
    $exception->getMessage();
}
?>
