<!DOCTYPE html>
<html>
<body>

<?php
for ($x = 0; $x <= 100; $x++) {
    if ($x % 2 == 0) {
        echo "<b>$x</b>";
    } else {
        echo "$x";
        $style = "color:red";
    }
    echo "<br>";
}
?>

</body>
</html>