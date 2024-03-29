<?php
session_start();
?>
<!DOCTYPE HTML>
<html>

<head>
    <title>PDO - Login - PHP CRUD Tutorial</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
</head>

<body>
    <!-- container -->
    <div class="container">
        <div class="page-header">
            <h1>Login</h1>
        </div>
        <!-- PHP insert code will be here -->
        <?php
        $save = true;
        $msg = "";
        if (!empty($_POST)) {
            // posted values

            //email//
            $passww = htmlspecialchars(strip_tags($_POST['passww']));
            if (empty($passww)) {
                $msg = $msg . "Please do not leave password empty<br>";
                $save = false;
            }
            $email = htmlspecialchars(strip_tags($_POST['email']));
            if (empty($email)) {
                $msg = $msg . "Please do not leave email empty<br>";
                $save = false;
            } elseif (!preg_match("/@/", $email)) {
                $msg = "Invalid email format<br>";
                $save = false;
            } else {
                include 'config/database.php';
                $query = "SELECT email, passw, status FROM customer WHERE email=:email";
                $stmt = $con->prepare($query);
                $stmt->bindParam(':email', $email);
                $stmt->execute();
                $num = $stmt->rowCount();
                if ($num == 0) {
                    $msg = "This email is not fund<br>";
                    $save = false;
                } else {
                    $row = $stmt->fetch(PDO::FETCH_ASSOC);
                    $email = $row['email'];
                    $passw = $row['passw'];
                    $status = $row['status'];
                    if ($passww != $passw) {
                        $msg = "Wrong password<br>";
                        $save = false;
                    } else {
                        if ($status == "deactive") {
                            $msg = "You are deactive<br>";
                            $save = false;
                        }
                    }
                }
            }
            if ($save != false) {
                // Set session variables
                $_SESSION["login"] = $email;

                header('Location: customer_dashboard.php');
            } else {
                echo "<div class='alert alert-danger'><b>Unable to login:</b><br>$msg</div>";
            }
        }
        ?>

        <!-- html form here where the product information will be entered -->
        <form name="customer" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" onsubmit="return validateForm()" method="post" required>
            <table class='table table-hover table-responsive table-bordered'>

                <tr>
                    <td>Email</td>
                    <td><input type='text' name='email' class='form-control' value="<?php if (isset($_POST['email'])) echo $_POST['email']; ?>" /></td>
                </tr>
                <tr>
                    <td>Password</td>
                    <td><input type='password' name='passww' class='form-control' value="<?php if (isset($_POST['passww'])) echo $_POST['passww']; ?>" id='myInput'/>

                    <input type="checkbox" onclick="myFunction()">Show Password
                </tr>

                <tr>
                    <td></td>
                    <td>
                        <input type='submit' a href='product_read.php' value='Login' class='btn btn-primary' />
                    </td>
                </tr>
            </table>
        </form>

    </div>
    <!-- end .container -->
    <footer>
        <?php include 'footer'; ?>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

    <script>
        function myFunction() {
            var x = document.getElementById("myInput");
            if (x.type === "password") {
                x.type = "text";
            } else {
                x.type = "password";
            }
        }
    </script>

</body>

</html>