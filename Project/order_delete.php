<?php
// include database connection
include 'config/database.php';
try {     
    // get record ID
    // isset() is a PHP function used to verify if a value is there or not
    $id = isset($_GET['OrderID']) ? $_GET['OrderID'] :  die('ERROR: Record ID not found.');

    // delete query
    $query = "DELETE orders , orderdetails FROM orders INNER JOIN orderdetails ON orders.OrderID = orderdetails.OrderID WHERE orders.OrderID = ? and orderdetails.OrderID = 1";
    $stmt = $con->prepare($query);
    $stmt->bindParam(1, $id);
     
    if($stmt->execute()){
        // redirect to read records page and
        // tell the user record was deleted
        header('Location: order_read.php?action=deleted');
    }else{
        die('Unable to delete record.');
    }
}
// show error
catch(PDOException $exception){
    die('ERROR: ' . $exception->getMessage());
}
?>