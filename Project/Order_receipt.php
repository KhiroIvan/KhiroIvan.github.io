<!DOCTYPE HTML>
<html>

<head>
    <title>PDO - Read One Record - PHP CRUD Tutorial</title>
    <!-- Latest compiled and minified Bootstrap CSS -->
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
</head>

<body>

    <!-- container -->
    <div class="container">
        <div class="page-header">
            <h1>Receipt</h1>
        </div>

        <!-- PHP read one record will be here -->
        <?php

        //include database connection
        include 'config/database.php';

        // read current record's data
        try {
            // prepare select query
            $query = "SELECT O.OrderID, C.first_name, C.last_name 
                      FROM orders O 
                      INNER JOIN customer C ON O.CustomerID = C.id";
                      
            $stmt = $con->prepare($query);

            // execute our query
            $stmt->execute();
            
            // store retrieved row to a variable
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            // values to fill up our form  //extract($row);
            $OrderID = $row['OrderID'];
            $first_name = $row['first_name'];
            $last_name = $row['last_name'];
        }

        // show error
        catch (PDOException $exception) {
            die('ERROR: ' . $exception->getMessage());
        }
        ?>

        <!-- HTML read one record table will be here -->
        <!--we have our html table here where the record will be displayed-->
        <table class='table table-hover table-responsive table-bordered'>
            <tr>
                <td>OrderID</td>
                <td><?php echo htmlspecialchars($OrderID, ENT_QUOTES);  ?></td>
            </tr>
            <tr>
                <td>Name</td>
                <td><?php echo htmlspecialchars($first_name." ".$last_name, ENT_QUOTES);  ?></td>
            </tr>

        </table>

    </div> <!-- end .container -->

</body>

</html>