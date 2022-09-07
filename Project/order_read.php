<?php
session_start();

if(!isset($_SESSION["login"])){
    header('Location: index.php');
}
?>
<!DOCTYPE HTML>
<html>

<head>
    <title>PDO - Create a Record - PHP CRUD Tutorial</title>
    <!-- Latest compiled and minified Bootstrap CSS -->
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <?php include 'header.php';?>
</head>

<body>
    <!-- container -->
    <div class="container">
        <div class="page-header">
            <h1>Read Orders</h1>
        </div>

        <!-- PHP code to read records will be here -->
        <?php
        // include database connection
        include 'config/database.php';

        // delete message prompt will be here
        $action = isset($_GET['action']) ? $_GET['action'] : "";
 
        // if it was redirected from delete.php
        if($action=='deleted'){
            echo "<div class='alert alert-success'>Record was deleted.</div>";
        }


        // select all data
        $query = "SELECT * FROM orders ORDER BY OrderID DESC";
        $stmt = $con->prepare($query);
        $stmt->execute();

        // this is how to get number of rows returned
        $num = $stmt->rowCount();

        //check if more than 0 record found
        if ($num > 0) {

            // data from database will be here
            echo "<table class='table table-hover table-responsive table-bordered'>"; //start table

            //creating our table heading
            echo "<tr>";
            echo "<th>Order ID</th>";
            echo "<th>Customer ID</th>";
            echo "<th>Order Date</th>";
            echo "</tr>";

            // table body will be here
            // retrieve our table contents
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                // extract row
                extract($row);
                // creating new table row per record
                echo "<tr>";
                echo "<td>{$OrderID}</td>";
                echo "<td>{$CustomerID}</td>";
                echo "<td>{$OrderTime}</td>";
                echo "<td>";
                // read one record
                echo "<a href='order_read_one.php?OrderID={$OrderID}' class='btn btn-info m-r-1em'>Read</a>";
                // we will use this links on next part of this post
                echo "<a href='order_update.php?OrderID={$OrderID}' class='btn btn-primary m-r-1em'>Edit</a>";
                // we will use this links on next part of this post
                echo "<a href='#' onclick='delete_order({$OrderID});'  class='btn btn-danger'>Delete</a>";
                echo "</td>";
                echo "</tr>";
            }


            // end table
            echo "</table>";
        }
        // if no records found
        else {
            echo "<div class='alert alert-danger'>No records found.</div>";
        }
        ?>

    </div> <!-- end .container -->

    <!-- confirm delete record will be here -->
    <script>
    // confirm record deletion
    function delete_order(id){
        
        var answer = confirm('Are you sure?');
        if (answer){
            // if user clicked ok,
            // pass the id to delete.php and execute the delete query
            window.location = 'order_delete.php?OrderID=' + id;
        }
    }
    
    </script>
<footer>
        <?php include 'footer';?>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>

</html>