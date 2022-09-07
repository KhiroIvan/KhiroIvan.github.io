<?php
session_start();

if(!isset($_SESSION["login"])){
    header('Location: index.php');
}
?>
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

function validateDate($date, $format = 'Y-n-j')
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
    <?php include 'header.php';?>
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

            $emptyMes = "";

            $name = $_POST['name'];

            if (empty($name)) {
                $emptyMes = $emptyMes . "please do not leave name empty<br>";
                $save = false;
            }

            $description = $_POST['description'];

            $price = $_POST['price'];

            if (empty($price)) {
                $emptyMes = $emptyMes . "please do not leave price empty<br>";
                $save = false;
            } else if (is_numeric($price) == false) {
                $emptyMes = $emptyMes . "please use numbers only<br>";
                $save = false;
            }

            $manu_date = $_POST['manu_date_year'] . "-" . $_POST['manu_date_month'] . "-" . $_POST['manu_date_day'];
            if (validateDate($manu_date) == false) {
                $emptyMes = $emptyMes . "Manufacture selected date does not exist<br>";
                $save = false;
            }


            $expiry_date = $_POST['expiry_date_year'] . "-" . $_POST['expiry_date_month'] . "-" . $_POST['expiry_date_day'];
            $ManDate = date_create($manu_date);
            $ExDate = date_create($expiry_date);
            $x = date_diff($ManDate, $ExDate);

            if (validateDate($expiry_date) == false) {
                $emptyMes = $emptyMes . "Expiry selected date does not exist<br>";
                $save = false;
            }

            if((int)($x->format("%m") > 1)){
                if((int)($x->format("%R%a") <= 0)){
                    $msg = $msg . "Expiry date should not earlier than manufacture date<br>";
                    $save = false;
                }
            }else{
                if ((int)($x->format("%m") < 1)){
                    $msg = $msg . "Expiry date should earlier than manufacture one month<br>";
                    $save = false;
                }
            }

            if (isset($_POST['status'])) {
                $status = htmlspecialchars(strip_tags($_POST['status']));
            } else {
                $emptyMes = $emptyMes . "please do not leave status empty<br>";
                $save = false;
            }

            // new 'image' field
            $image = !empty($_FILES["image"]["name"])
                ? sha1_file($_FILES['image']['tmp_name']) . "-" . basename($_FILES["image"]["name"])
                : "";
            $image = htmlspecialchars(strip_tags($image));
            if ($image) {

                $target_directory = "uploads/";
                $target_file = $target_directory . $image;
                $file_type = pathinfo($target_file, PATHINFO_EXTENSION);

                // error message is empty
                $file_upload_error_messages = "";

                // make sure certain file types are allowed
                $allowed_file_types = array("jpg", "jpeg", "png", "gif");
                if (!in_array($file_type, $allowed_file_types)) {
                    $file_upload_error_messages .= "<div>Only JPG, JPEG, PNG, GIF files are allowed.</div>";
                }
                // make sure file does not exist
                if (file_exists($target_file)) {
                    $file_upload_error_messages .= "<div>Image already exists. Try to change file name.</div>";
                }
                // make sure submitted file is not too large, can't be larger than 1MB
                if ($_FILES['image']['size'] > 1024000) {
                    $file_upload_error_messages .= "<div>Image must be less than 1 MB in size.</div>";
                }
                // make sure the 'uploads' folder exists
                // if not, create it
                if (!is_dir($target_directory)) {
                    mkdir($target_directory, 0777, true);
                }
            }
            // if $file_upload_error_messages is still empty
            if(empty($file_upload_error_messages)){
                // it means there are no errors, so try to upload the file
                if(move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)){
                    // it means photo was uploaded
                }else{
                    $emptyMes = $emptyMes . "There is no photo.<br>";
                    $save = false;
                }
            }// if $file_upload_error_messages is NOT empty
            else{
                $emptyMes = $emptyMes . "There is no photo.<br>";
                $save = false;

                if (isset($_POST['filePath'])){
                    $filePath = $_POST['filePath'];

                    if (file_exists($filePath)){
                        unlink($filePath);
                        echo "Your file is deleted";
                    }else{
                        echo "Your file is not deleted";
                    }
                }
                
            }

            // include database connection
            include 'config/database.php';
            try {
                // insert query
                $query = "INSERT INTO products SET name=:name, description=:description, price=:price, manu_date=:manu_date, expiry_date=:expiry_date, status=:status, image=:image, created=:created";
                // prepare query for execution
                $stmt = $con->prepare($query);

                // bind the parameters
                $stmt->bindParam(':name', $name);
                $stmt->bindParam(':description', $description);
                $stmt->bindParam(':price', $price);
                $stmt->bindParam(':image', $image);
                $stmt->bindParam(':manu_date', $manu_date);
                $stmt->bindParam(':expiry_date', $expiry_date);
                $stmt->bindParam(':status', $status);
                // specify when this record was inserted to the database
                $created = date('Y-m-d H:i:s');
                $stmt->bindParam(':created', $created);
                // Execute the query


                if ($save != false) {
                    echo "<div class='alert alert-success'> Record was saved.</div>";
                    $stmt->execute();
                } else {
                    echo "<div class='alert alert-danger'> Unable to save record.<br>$emptyMes</div>";
                }
            }
            // show error
            catch (PDOException $exception) {
                die('ERROR: ' . $exception->getMessage());
            }
        }

        ?>
        <!-- html form here where the product information will be entered -->

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
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
                    <td>Photo</td>
                    <td><input type="file" name="image"/>
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
                        <input type="radio" name='status' value="available" <?php if (isset($_POST['status']) && ($status == "available")) echo 'checked'; ?>> <label for="html"> Available</label>

                        &nbsp;

                        <input type="radio" name='status' value="un_available" <?php if (isset($_POST['status']) && ($status == "un_available")) echo 'checked'; ?>><label for="html"> Un-available</label>
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td>
                        <input type='submit' value='Save' class='btn btn-primary' />
                        <a href='product_read.php' class='btn btn-danger'>Back to read products</a>
                    </td>
                </tr>
            </table>
        </form>


    </div>
    <!-- end .container -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <footer>
        <?php include 'footer';?>
    </footer>

</body>

</html>