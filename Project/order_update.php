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
            <h1>Order Update</h1>
        </div>

        <!-- PHP read record by ID will be here -->
        <?php
        // get passed parameter value, in this case, the record ID
        // isset() is a PHP function used to verify if a value is there or not
        $orderID = isset($_GET['OrderID']) ? $_GET['OrderID'] : die('ERROR: Record ID not found.');

        //include database connection
        include 'config/database.php';
        

        // check if form was submitted
        
        if ($_POST) {
            //echo "post";
            // posted values
            $orderDetailsID  = $_POST['OrderDetailsID'];
            $product_ID  = $_POST['ProductID'];
            $quantity = $_POST['Quantity'];
            

            //print_r( $product_id) ;

            for ($i = 0; $i < count($product_ID); $i++) {
                try {
                    // write update query
                    // in this case, it seemed like we have so many fields to pass and
                    // it is better to label them and not use question marks
                    $query = "UPDATE orderdetails SET ProductID  = :ProductID, Quantity = :Quantity   WHERE OrderDetailsID = :OrderDetailsID";
                    // prepare query for excecution
                    $stmt = $con->prepare($query);

                    // bind the parameters
                    $stmt->bindParam(':OrderDetailsID', $OrderDetailsID[$i]);
                    $stmt->bindParam(':ProductID', $ProductID[$i]);
                    $stmt->bindParam(':Quantity', $Quantity[$i]);

                    // Execute the query
                    if ($stmt->execute()) {
                        if ($i + 1 == count($product_id)) {
                            ob_end_clean();
                            //$_SESSION['success_update'] = "<div class='alert alert-success text-white'>Record was Updated.</div>";
                            header('Location: order_read.php?action=updated');
                        }
                    } else {
                        echo "<div class='alert alert-danger text-white'>Unable to update record. Please try again.</div>";
                    }
                }
                // show errors
                catch (PDOException $exception) {
                    die('ERROR: ' . $exception->getMessage());
                }
            }
        } else {
            // read current record's data


            try {
                // prepare select query
                $query = "SELECT * FROM orderdetails  WHERE OrderID  = ?";
                $stmt = $con->prepare($query);

                // this is the first question mark
                $stmt->bindParam(1, $orderID);

                // execute our query
                $stmt->execute();

                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    // values to fill up our form
                    $orderDetailsID[] = $row['OrderDetailsID'];
                    $product_ID[] = $row['ProductID'];
                    $quantity[] = $row['Quantity'];
                }
            }

            // show error
            catch (PDOException $exception) {
                die('ERROR: ' . $exception->getMessage());
            }
        
        ?>

        <!-- HTML form to update record will be here -->
        <!-- PHP post to update record will be here -->



        <!--we have our html form here where new record information can be updated-->
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] . "?orderID={$OrderID}"); ?>" method="post" enctype="multipart/form-data">
            <table class='table table-hover table-responsive table-bordered'>

                <?php
                for ($x = 0; $x < count($quantity); $x++) { 
                    try {
                        // prepare select query
                        $query = "SELECT * FROM products";
                        $stmt = $con->prepare($query);

                        // execute our query
                        $stmt->execute();
                        echo '<tr class="productrow border border-3">
                            <td class="border border-3 p-4">Select Product</td>
                            <td>
                            <div class="col">';
                        echo "<select class='form_select' name='product_id[]' >";
                        echo '<option selected>Product</option>';
                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                            extract($row);

                            if ($product_id[$x] == $id) {
                                echo "<option value='" . $id . "' selected >" . $name . "</option>";
                            } else {
                                echo "<option value='" . $id . "' >" . $name . "</option>";
                            }
                        }
                        echo "</select>
                        </div>
                            <div class='input-group input-group-outline my-2'>
                            <input type='number' name='quantity[]' class='form-control' value='" . $quantity[$x] . "'/>
                            <input type='hidden' name='order_details_id[]' value='" . $orderDetailsID[$x]. "'/></div>";
                    }
                    // show error
                    catch (PDOException $exception) {
                        die('ERROR: ' . $exception->getMessage());
                    }
                }
                ?>

            </table>
            <div class="d-flex justify-content-start gap-2">
                <div>
                    <button type="button" class="add">Add More Product</button>
                    <button type="button" class="del">Delete Last Product</button>
                </div>
            </div>

            <div class="d-flex justify-content-end gap-2">

                <input type='submit' value='Save Changes' class='btn btn-primary' />
                <a href='order_read.php' class='btn btn-danger'>Back to Order List</a>
            </div>
        </form>
        <?php }?>
        


    </div>
    <!-- end .container -->
    <script>
        document.addEventListener('click', function(event) {
            if (event.target.matches('.add')) {
                var element = document.querySelector('.productrow');
                var clone = element.cloneNode(true);
                element.after(clone);
            }
            if (event.target.matches('.del')) {
                var total = document.querySelectorAll('.productrow').length;
                if (total > 1) {
                    var element = document.querySelector('.productrow');
                    element.remove(element);
                }
            }
        }, false);
    </script>
    <footer>
        <?php include 'footer';?>
    </footer>
</body>

</html>