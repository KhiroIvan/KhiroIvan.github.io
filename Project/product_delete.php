<?php
// include database connection
include 'config/database.php';



try {     
    // get record ID
    // isset() is a PHP function used to verify if a value is there or not
    $id = isset($_GET['id']) ? $_GET['id'] :  die('ERROR: Record ID not found.');

    $query = "SELECT image FROM products WHERE id = ? ";
    $stmt = $con->prepare($query);
    // this is the first question mark
    $stmt->bindParam(1, $id);
    // execute our query
    $stmt->execute();

    // store retrieved row to a variable
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $image = $row['image'];
   

    // delete query
    $query = "DELETE FROM products WHERE id = ?";
    $stmt = $con->prepare($query);
    $stmt->bindParam(1, $id);
    unlink("uploads/".$image); 

    if($stmt->execute()){
        // redirect to read records page and
        // tell the user record was deleted
        header('Location: product_read.php?action=deleted');
    }else{
        die('Unable to delete record.');
    }
}
// show error
catch(PDOException $exception){
    die('ERROR: ' . $exception->getMessage());
}
?>
