<!DOCTYPE html>
<html>

<head>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <title>Half Diamond</title>

</head>

<body>

<?php

for ($x = 1; $x < 6; $x++) {
    for ($y = 0; $y < $x; $y++) {
        echo "*";
    }
    echo "<br>";
}

for ($x = 5; $x > 0; $x--) {
    for ($y = 0; $y < $x; $y++) {

        echo "*";
    }
    echo "<br>";
}
?>
</body>
</html>