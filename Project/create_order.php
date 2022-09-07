<?php
session_start();

if(!isset($_SESSION["login"])){
    header('Location: index.php');
}
?>
<!DOCTYPE HTML>
<html>

<head>
    <title>Create Order</title>
    <?php include 'header.php';?>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
</head>

<?php
include 'config/database.php';


if ($_POST) {
    $CustomerID = $_POST['customer'];
    $query = "INSERT INTO orders SET CustomerID=:CustomerID, OrderTime=:OrderTime";

    $stmt = $con->prepare($query);
    $stmt->bindParam(':CustomerID', $CustomerID);
    $OrderTime = date('Y-m-d H:i:s');
    $stmt->bindParam(':OrderTime', $OrderTime);
    $stmt->execute();
    $OrderID = $con->lastInsertId();

    $ProductID = $_POST['product'];
    $Quantity = $_POST['quantity'];
    for ($i = 0; $i < count($ProductID); $i++) {
        $query = "INSERT INTO orderdetails SET OrderID=:OrderID, ProductID=:ProductID , Quantity=:Quantity";

        $stmt = $con->prepare($query);
        $stmt->bindParam(':OrderID', $OrderID);
        $stmt->bindParam(':ProductID', $ProductID[$i]);
        $stmt->bindParam(':Quantity', $Quantity[$i]);
        $stmt->execute();
    }
    header("Location: order_read_one.php?OrderID=$OrderID");
}
?>

<body>
    <div class="container">
        <div class="page-header">
            <h1>Create Order</h1>
        </div>
    <form action="" method="post">
        <table class="table">
        <tr class="customer-row">
                <td>Customer</td>
                <td>
                    <div class="row">
                        <div class="col">
                        <?php   
                            $query = "SELECT id, first_name, last_name FROM customer ORDER BY id DESC";
                            $stmt = $con->prepare($query);
                            $stmt->execute();

                            // this is how to get number of rows returned
                            $customer_num = $stmt->rowCount();
                            if($customer_num > 0){
                                echo '<select name="customer">';
                                    while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                                        extract($row);
                                        echo "<option value='$id'>$first_name $last_name</option>";
                                    }
                                    
                                echo '</select>';
                            }     
                        ?>
                        </div>
                        </div>
                    </td>
                </tr>
                        
            <tr class="product-row">
                <td>Product</td>
                <td>
                    <div class="row">
                        <div class="col">
                        <?php   
                            $query = "SELECT id, name FROM products ORDER BY id DESC";
                            $stmt = $con->prepare($query);
                            $stmt->execute();

                            // this is how to get number of rows returned
                            $product_num = $stmt->rowCount();
                            if($product_num > 0){
                                echo '<select name="product[]">';
                                    while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                                        extract($row);
                                        echo "<option value='$id'>$name</option>";
                                    }
                                    
                                echo '</select>';
                            }     
                        ?>
                        </div>
                        <div class="col">
                            <select name="quantity[]">
                                <option value="">Quantity</option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                                <option value="6">6</option>
                                <option value="7">7</option>
                                <option value="8">8</option>
                                <option value="9">9</option>
                                <option value="10">10</option>
                            </select>
                        </div>
                    </div>
                </td>
            </tr>
            
            <tr>
                <td colspan="2">
                    <div class="d-flex justify-content-center flex-column flex-lg-row">
                        <div class="d-flex justify-content-center">
                            <button type="button" class="add_one btn btn-primary">Add More Product</button>
                            <button type="button" class="del_last btn btn-info">Delete Last Product</button>
                            <button type="submit" class="btn btn-danger">Submit</button>
                        </div>
                    </div>
                </td>
            </tr>
        </table>
    </form>
    </div>


    <script>
        document.addEventListener('click', function(event) {
            if (event.target.matches('.add_one')) {
                var element = document.querySelector('.product-row');
                var clone = element.cloneNode(true);
                element.after(clone);
            }
            if (event.target.matches('.del_last')) {
                var total = document.querySelectorAll('.product-row').length;
                if (total > 1) {
                    var element = document.querySelector('.product-row');
                    element.remove(element);
                }
            }
        }, false);
    </script>
</body>