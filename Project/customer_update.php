<?php
function dropdown($sday = "", $smonth = "", $syear = "", $datetype = "")
{

    if (empty($sday)) {
        $sday = date('j');
    }

    if (empty($smonth)) {
        $smonth = date('n');
    }

    if (empty($syear)) {
        $syear = date('Y');
    }

    //---v---select day---v---//
    $nameday = $datetype . "_day";
    $namemonth = $datetype . "_month";
    $nameyear = $datetype . "_year";

    echo "<select name= $nameday>";
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
?>
<?php
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
    <title>PDO - Read Records - PHP CRUD Tutorial</title>
    <!-- Latest compiled and minified Bootstrap CSS -->
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
</head>

<body>
    <!-- container-->
    <div class="container">
        <div class="page-header">
            <h1>Update Customer</h1>
        </div>
        <!-- PHP read record by ID will be here -->
        <?php
        // get passed parameter value, in this case, the record ID
        // isset() is a PHP function used to verify if a value is there or not
        $id = isset($_GET['id']) ? $_GET['id'] : die('ERROR: Record ID not found.');

        //include database connection
        include 'config/database.php';

        // read current record's data
        try {
            // prepare select query
            $query = "SELECT id, first_name, last_name, email, passw, birth_date, gender, status FROM customer WHERE id = ? ";
            $stmt = $con->prepare($query);

            // this is the first question mark
            $stmt->bindParam(1, $id);

            // execute our query
            $stmt->execute();

            // store retrieved row to a variable
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            // values to fill up our form
            $first_name = $row['first_name'];
            $last_name = $row['last_name'];
            $email = $row['email'];
            $passw = $row['passw'];
            $birth_date = $row['birth_date'];
            $gender = $row['gender'];
            $status = $row['status'];
        }

        // show error
        catch (PDOException $exception) {
            die('ERROR: ' . $exception->getMessage());
        }
        ?>

        <!-- HTML form to update record will be here -->
        <!-- PHP post to update record will be here -->
        <?php
        // check if form was submitted
        $save = true;
        if (!empty($_POST)) {
            // posted values
            //name check//
            $msg = "";
            $first_name = htmlspecialchars(strip_tags($_POST['first_name']));
            if (empty($first_name)) {
                $msg = $msg . "Please do not leave first name empty<br>";
                $save = false;
            }
            $last_name = htmlspecialchars(strip_tags($_POST['last_name']));
            if (empty($last_name)) {
                $msg = $msg . "Please do not leave last name empty<br>";
                $save = false;
            }

            //email//
            $email = htmlspecialchars(strip_tags($_POST['email']));
            if (empty($email)) {
                $msg = $msg . "Please do not leave email empty<br>";
                $save = false;
            } elseif (!preg_match("/@/", $email)) {
                $msg = "Invalid email format<br>";
                $save = false;
            }

            $passw = htmlspecialchars(strip_tags($_POST['passw']));
            if (empty($passw)) {
                $msg = $msg . "Please do not leave password empty<br>";
                $save = false;
            } elseif (strlen($passw) <= 5||!preg_match("/[a-z]/", $passw) || !preg_match("/[A-Z]/", $passw) || !preg_match("/[1-9]/", $passw)) {
                $msg = $msg . "Invalid password format (Password format should be more than 6 character, at least 1 uppercase, 1 lowercase & 1 number)<br>";
                $save = false;
            }
            
            $confirmpassw = $_POST['confirmpassw'];
            if (empty($confirmpassw)) {
                $msg = $msg . "Please do not leave confirm password empty<br>";
                $save = false;
            }elseif ($confirmpassw != $passw){
                $msg = $msg ."Password must be same with confirm password";
                $save = false;
            }

            //birth date check//
            $birth_date = $_POST['birth_date_year'] . "-" . $_POST['birth_date_month'] . "-" . $_POST['birth_date_day'];
            $today = date('Y-n-j');
            $date1 = date_create($birth_date);
            $date2 = date_create($today);
            $diff = date_diff($date1, $date2);
            if (validateDate($birth_date) == false) {
                $msg = $msg . "Birthdate selected is not exist<br>";
                $save = false;
            } elseif ($diff->format("%R%a") < 6570) {
                $msg = $msg . "Customer must be over 18 years old<br>";
                $save = false;
            }

            //status check//
            if (isset($_POST['gender'])) {
                $gender = htmlspecialchars(strip_tags($_POST['gender']));   
            }else{
                $msg = $msg . "Please do not leave gender empty<br>";
                $save = false;
            }
            
            if (isset($_POST['status'])) {
                $status = htmlspecialchars(strip_tags($_POST['status']));  
            }else{
                $msg = $msg . "Please do not leave status empty<br>";
                $save = false;
            }

                // write update query
                // in this case, it seemed like we have so many fields to pass and
                // it is better to label them and not use question marks
                $query = "UPDATE customer SET first_name=:first_name, last_name=:last_name, email=:email, passw=:passw, birth_date=:birth_date, gender=:gender, status=:status WHERE id = :id";

                $stmt = $con->prepare($query);
                $stmt->bindParam(':first_name', $first_name);
                $stmt->bindParam(':last_name', $last_name);
                $stmt->bindParam(':email', $email);
                $stmt->bindParam(':passw', $passw);
                $stmt->bindParam(':birth_date', $birth_date);
                $stmt->bindParam(':gender', $gender);
                $stmt->bindParam(':status', $status);
                $stmt->bindParam(':id', $id);
                
                if ($save != false) {
                    echo "<div class='alert alert-success'>Record was saved.</div>";
                    $stmt->execute();
                } else {
                    echo "<div class='alert alert-danger'><b>Unable to save record:</b><br>$msg</div>";
                }
         
        
        } ?>


        <!--we have our html form here where new record information can be updated-->
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] . "?id={$id}"); ?>" method="post">
            <table class='table table-hover table-responsive table-bordered'>
                <tr>
                    <td>First Name</td>
                    <td><input type='text' name='first_name' value="<?php echo htmlspecialchars($first_name, ENT_QUOTES);  ?>" class='form-control' /></td>
                </tr>
                <tr>
                    <td>Last Name</td>
                    <td><input type='text' name='last_name' value="<?php echo htmlspecialchars($last_name, ENT_QUOTES);  ?>" class='form-control' /></td>
                </tr>
                <tr>
                    <td>Email</td>
                    <td><textarea name='email' class='form-control'><?php echo htmlspecialchars($email, ENT_QUOTES);  ?></textarea></td>
                </tr>
                <tr>
                    <td>Password</td>
                    <td><input type='text' name='passw' value="<?php echo htmlspecialchars($passw, ENT_QUOTES);  ?>" class='form-control' /></td>
                </tr>
                <tr>
                    <td>Confirm Password</td>
                    <td><input type='text' name='confirmpassw' value="<?php if (isset($_POST['confirmpassw'])) echo $_POST['confirmpassw']; ?>" class='form-control' /></td>
                </tr>
                <tr>
                    <td>Date of Birth </td>
                    <td>
                        <?php
                        $yearsave_birth = substr($birth_date,0,4);
                        $monthsave_birth = substr($birth_date,5,2);
                        $daysave_birth = substr($birth_date,8,2);
                        dropdown($sday = $daysave_birth, $smonth = $monthsave_birth, $syear = $yearsave_birth, $datetype = "birth_date");
                        ?>
                    </td>

                </tr>
                <tr>
                    <td>Gender</td>
                    <td>
                        <input type="radio" name="gender" value="male" <?php if($gender == "male") echo 'checked'; ?>><label>Male</label>&nbsp;
                        <input type="radio" name="gender" value="female" <?php if ($gender == "female") echo 'checked'; ?>><label>Female</label>
                    </td>
                </tr>
                <tr>
                    <td>Status</td>
                    <td>
                        <input type="radio" name="status" value="active" <?php if($status == "active") echo 'checked'; ?>><label>Active</label>&nbsp;
                        <input type="radio" name="status" value="deactive" <?php if ($status == "deactive") echo 'checked'; ?>><label>Deactive</label>
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td>
                        <input type='submit' value='Save Changes' class='btn btn-primary' />
                        <a href='customer_read.php' class='btn btn-danger'>Back to read customer list</a>
                    </td>
                </tr>
            </table>
        </form>

    </div>
    <!-- end .container -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>

</html>