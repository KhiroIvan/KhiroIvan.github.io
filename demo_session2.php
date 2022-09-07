<?php
session_start();
?>
<!DOCTYPE html>
<html>
<body>

<?php
// Echo session variables that were set on previous page

if(isset($_SESSION["favcolor"])){
    echo "There is a session, fav colour is ". $_SESSION["favcolor"] . ".<br>";
}else{
    header('Location: demo_session1.php');
}

if(isset($_SESSION["favanimal"])){
    echo "There is a session, fav animal is ". $_SESSION["favanimal"] . ".<br>";
}else{
    header('Location: demo_session1.php');
}

?>

</body>
</html>