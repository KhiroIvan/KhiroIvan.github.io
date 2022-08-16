<!DOCTYPE HTML>
<html>

<head>
    <title>PDO - Login - PHP CRUD Tutorial</title>
    <!-- Latest compiled and minified Bootstrap CSS -->
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
</head>
<body>
 
    <!-- container -->
    <div class="container">
        <div class="page-header">
            <h1>Login</h1>
        </div>

        <!-- PHP read one record will be here -->
        <?php
        $email = isset($_GET['email']) ? $_GET['email'] : die('ERROR: Record ID not found.');
        //include database connection
        include 'config/database.php';

        // read current record's data
        try {
            // prepare select query
            $query = "SELECT id, first_name, last_name, email, passw, birth_date, gender, status FROM customer WHERE email = ? ";
            $stmt = $con->prepare($query);

            // this is the first question mark
            $stmt->bindParam(1, $email);

            // execute our query
            $stmt->execute();

            // store retrieved row to a variable
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            // values to fill up our form  //extract($row);
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

        <?php
        //$emaill = isset($_POST['emaill']);
        $stmt->bindParam(':emaill', $emaill);
        $stmt->bindParam(':passwd', $passwd);
        //$stmt->execute();
        if (!empty($_POST)) {
            $save = true;
            $msg = "";

            
            $emaill = $_POST['emaill'];
                if (empty($emaill)) {
                    $msg = $msg . "Please do not leave email empty<br>";
                    $save = false;
                }elseif (!preg_match("/@/", $emaill)) {
                    $msg = $msg . "Invalid email format<br>";
                    $save = false;
                }elseif($emaill != $email){
                    $msg = $msg . "This email is not fund<br>";
                    $save = false;
                }

                
            
            
            $passwd = $_POST['passwd'];
                if (empty($passwd)) {
                    $msg = $msg . "Please do not leave password empty<br>";
                    $save = false;
                } elseif (strlen($passwd) <= 5 || !preg_match("/[a-z]/", $passwd) || !preg_match("/[A-Z]/", $passwd) || !preg_match("/[1-9]/", $passwd)) {
                    $msg = $msg . "Invalid password format (Password format should be more than 6 character, at least 1 uppercase, 1 lowercase & 1 number)<br>";
                    $save = false;
                }elseif($passwd != $passw){
                    $msg = $msg . "This email is not fund<br>";
                    $save = false;
                }
            

            if($status == "deactive"){
                $msg = $msg . "You are deactive<br>";
                $save = false;
            }

            if ($save != false) {
                header('Location: dashboard.php');
            } else {
                echo "<div class='alert alert-danger'><b>Unable to login:</b><br>$msg</div>";
            } 
        }
        ?>

        <!-- HTML read one record table will be here -->
        <!--we have our html table here where the record will be displayed-->
        <form  action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
            <table class='table table-hover table-responsive table-bordered'>
                <tr>
                    <td>Email</td>
                    <td><input type='text' name='emaill' class='form-control' value= "<?php if (isset($_POST['emaill'])) echo $_POST['emaill']; ?>" /></td>
                </tr>
                <tr>
                    <td>Password</td>
                    <td><input type='text' name='passwd' class='form-control' value= "<?php if (isset($_POST['passwd'])) echo $_POST['passwd']; ?>" /></td>
                </tr>
                <tr>
                    <td></td>
                    <td>
                        <input type='submit' value='Login' class='btn btn-primary' />
                    </td>
                </tr>
                
                <!-- <tr>
                    <td>Email</td>
                    <td><?php echo htmlspecialchars($email, ENT_QUOTES);  ?></td>
                </tr>
                <tr>
                    <td>Password</td>
                    <td><?php echo htmlspecialchars($passw, ENT_QUOTES);  ?></td>
                </tr>
                
                <tr>
                    <td>Status</td>
                    <td><?php echo htmlspecialchars($status, ENT_QUOTES);  ?></td>
                </tr> -->
            </table>
        </form>

    </div> <!-- end .container -->

    </body>

</html>