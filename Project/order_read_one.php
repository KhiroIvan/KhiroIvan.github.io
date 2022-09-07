<?php
session_start();

if(!isset($_SESSION["login"])){
    header('Location: customer_login.php');
}
?>
<!DOCTYPE HTML>
<html>
<style>
.div1{
         text-align:right; 
         float: right;
         width:50%;
         display:block;
   }
</style>
<head>
    <title>PDO - Read One Record - PHP CRUD Tutorial</title>
    <!-- Latest compiled and minified Bootstrap CSS -->
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <?php include 'header.php';?>
</head>
<body>
 
    <!-- container -->
    <div class="container">
        <div class="page-header">
            <h1>Receipt Details</h1>
        </div>

        <!-- PHP read one record will be here -->
        <?php
    //get order_id from url
    $orderid = $_GET['OrderID'];
    
        include 'config/database.php';
        try{
            //customer order detail
            $query ="SELECT orders.OrderID, orders.OrderTime, customer.first_name, customer.last_name FROM orders
            INNER JOIN customer ON orders.CustomerID = customer.id WHERE orders.OrderID =$orderid "; 
            
            $stmt = $con->prepare($query);
            $stmt->execute();

            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $OrderID = $row['OrderID'];
            $first_name = $row['first_name'];
            $last_name = $row['last_name'];
            $OrderTime = $row['OrderTime'];

        }// show error
        catch (PDOException $exception) {
            die('ERROR: ' . $exception->getMessage());
        }


    ?>
    <table class='table table-hover table-responsive table-bordered'>
            <tr>
                <td><b>Order ID</b></td>
                <td><?php echo htmlspecialchars($OrderID, ENT_QUOTES);  ?></td>
            </tr>
            <tr>
                <td><b>Customer Name</b></td>
                <td><?php echo htmlspecialchars($first_name.$last_name, ENT_QUOTES);  ?></td>
            </tr>
            <tr>
                <td><b>Order Date</b></td>
                <td><?php echo htmlspecialchars($OrderTime, ENT_QUOTES);  ?></td>
            </tr>
        </table>


            <?php
            include 'config/database.php';
            //order product detail
            $query = "SELECT * FROM orderdetails INNER JOIN products ON orderdetails.ProductID = products.id WHERE orderdetails.OrderID =$orderid";
            $stmt = $con->prepare($query);
            $stmt->execute();
            $TotalAmount = 0;
            $num = $stmt->rowCount();
            if ($num > 0) {
                echo "<table class='table table-hover table-responsive table-bordered'>";

                echo "<tr>";
                echo "<th>Product Name</th>";
                echo "<th>Single Price</th>";
                echo "<th>Quantity</th>";
                echo "<th><div class='div1'>Total Price</div></th>";
                echo "</tr>";
                

                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    // extract row
                    extract($row);

                    $totalPrice = $price*$Quantity;
                    $TotalAmount = $TotalAmount + $totalPrice;
                    
                    // creating new table row per record
                    echo "<tr>";
                    echo "<td>{$name}</td>";
                    $priceFormat = number_format($price, 2);
                    echo "<td>RM&nbsp{$priceFormat}</td>";
                    echo "<td>{$Quantity}</td>";
                    $totalPriceFormat = number_format($totalPrice, 2);
                    echo "<td><div class='div1'>RM&nbsp$totalPriceFormat</div></td>";
                }
                
            }
            ?>

            <table class='table table-hover table-responsive table-bordered'>
                <tr>
                    <td><b>Total Amount</b></td>
                    <td>
                        <div class="div1">
                            <span>
                                <?php 
                                $totalAmountFormat = number_format($TotalAmount, 2);
                                echo"RM&nbsp$totalAmountFormat"?>
                            </span>
                        </div>
                    </td>
                </tr>
            </table>

    </div> <!-- end .container -->
    <footer>
        <?php include 'footer';?>
    </footer>  

    </body>

</html>