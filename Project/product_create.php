<?php

function dropdown($sday = "", $smonth = "", $syear = "", $name = "")
{

    if (empty($sday)) {
        $sday = date('d');
    }

    if (empty($smonth)) {
        $smonth = date('m');
    }

    if (empty($syear)) {
        $syear = date('Y');
    }

    $nameday = $name . "_day";
    $namemonth = $name . "_month";
    $nameyear = $name . "_year";

    //---v---select day---v---//

    echo "<select name = $nameday>";
    for ($day = 1; $day <= 31; $day++) {
        $s = ($day == $sday) ? 'selected' : '';
        echo "<option value = $day $s> $day </option>";
    }
    echo '</select>';

    //---v---select month---v---//
    echo "<select name = $namemonth>";
    for ($month = 1; $month <= 12; $month++) {
        $s = ($month == $smonth) ? 'selected' : '';
        echo "<option value = $month $s>" . date('F', mktime(0, 0, 0, $month)) . "</option>";
    }
    echo '</select>';

    //---v---select year---v---//
    $nowyear = date('Y');
    echo "<select name = $nameyear>";
    for ($year = 1990; $year <= $nowyear; $year++) {
        $s = ($year == $syear) ? 'selected' : '';
        echo "<option value = $year $s> $year </option>";
    }
    echo '</select>';
    echo "<br>";
}

function validateDate($date, $format = 'Y-n-d')
{
    $d = DateTime::createFromFormat($format, $date);
    // The Y ( 4 digits year ) returns TRUE for any integer with any number of digits so changing the comparison from == to === fixes the issue.
    return $d && $d->format($format) === $date;
}
?>

<!DOCTYPE HTML>
<html>

<head>
    <title>PDO - Create a Record - PHP CRUD Tutorial</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
</head>

<body>
    <!-- container -->
    <div class="container">
        <div class="page-header">
            <h1>Create Product</h1>
        </div>
        <!-- html form to create product will be here -->

        <?php

        $save = true;

        if (!empty($_POST)) {

            // posted values

            $name = $_POST['name'];

            if (empty($name)) {
                echo "please do not leave name empty";
            }

            $description = $_POST['description'];

            $price = $_POST['price'];

            if (empty($price)) {
                echo "please do not leave price empty";
            }

            $manu_date = $_POST['manu_date_year'] . "-" . $_POST['manu_date_month'] . "-" . $_POST['manu_date_day'];
            if (validateDate($manu_date) == false) {
                echo "Manufacture selected date is not exist<br>";
                $save = false;
            }


            $expiry_date = $_POST['expiry_date_year'] . "-" . $_POST['expiry_date_month'] . "-" . $_POST['expiry_date_day'];


            if (validateDate($expiry_date) == false) {
                echo "Expiry selected date is not exist<br>";
                $save = false;
            }

            $ManDate = date_create($manu_date);
            $ExDate = date_create($expiry_date);
            $x = date_diff($ManDate, $ExDate);

            if ($x->format("%R%a") < 0) {
                echo "Expiry date should not earlier than manufacture date.<br>";
                $save = false;
            }

            $status = $_POST['status'];

            // include database connection
            include 'config/database.php';
            try {
                // insert query
                $query = "INSERT INTO products SET name=:name, description=:description, price=:price, manu_date=:manu_date, expiry_date=:expiry_date, status=:status, created=:created";
                // prepare query for execution
                $stmt = $con->prepare($query);


                // bind the parameters
                $stmt->bindParam(':name', $name);
                $stmt->bindParam(':description', $description);
                $stmt->bindParam(':price', $price);
                $stmt->bindParam(':manu_date', $manu_date);
                $stmt->bindParam(':expiry_date', $expiry_date);
                $stmt->bindParam(':status', $status);
                // specify when this record was inserted to the database
                $created = date('Y-m-d H:i:s');
                $stmt->bindParam(':created', $created);
                // Execute the query
                if (!empty($stmt->execute())) {
                    echo "<div class='alert alert-success'>Record was saved.</div>";
                } else {
                    echo "<div class='alert alert-danger'>Unable to save record.</div>";
                }
                if ($save != false) {
                    echo "<div class='alert alert-success'> Record was saved.</div>";
                    echo $stmt->execute();
                } else {
                    echo "<div class='alert alert-danger'> Unable to save record.</div>";
                }

            }
            // show error
            catch (PDOException $exception) {
                die('ERROR: ' . $exception->getMessage());
            }
        }

        ?>
        <!-- html form here where the product information will be entered -->

        <form name="productform" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <table class='table table-hover table-responsive table-bordered'>
                <tr>
                    <td>Name</td>
                    <td><input type='text' name='name' class='form-control' /></td>
                </tr>
                <tr>
                    <td>Description</td>
                    <td><textarea name='description' class='form-control'></textarea></td>
                </tr>
                <tr>
                    <td>Price</td>
                    <td><input type='text' name='price' class='form-control' /></td>
                </tr>
                <tr>
                    <td>Manufacture Date</td>
                    <td>
                        <?php dropdown($sday = "", $smonth = "", $syear = "2021", $name = "manu_date"); ?>
                    </td>
                </tr>
                <tr>
                    <td>Expiry Date</td>
                    <td>
                        <?php dropdown($sday = "", $smonth = "", $syear = "", $name = "expiry_date"); ?>
                    </td>
                </tr>
                <tr>
                    <td>Status</td>
                    <td>
                        <input type="radio" name='status' value="available"><label for="html">Available</label>&nbsp;
                        <input type="radio" name='status' value="non_available"><label for="html">Non Available</label>
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td>
                        <input type='submit' value='Save' class='btn btn-primary' />
                        <a href='index.php' class='btn btn-danger'>Back to read products</a>
                    </td>
                </tr>
            </table>
        </form>


    </div>
    <!-- end .container -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>


</body>

</html>