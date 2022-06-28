<!DOCTYPE html>
<html>

<head>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <title>Half Diamond</title>

</head>

<body>

<?php
$n = 5;

for ($i = 1; $i <= $n; $i++){
    for ($x = $n; $x >= $i; $x--){
        echo "&nbsp;&nbsp;";
    }
    for ($y = 1; $y <= $i; $y++){
        echo "* &nbsp;&nbsp;";
    }
    echo "<br>";
}

for ($i = $n-1; $i > 0; $i--){
    for ($x = $n; $x >= $i; $x--) {
        echo "&nbsp;&nbsp;";
    }
    for ($y = 1; $y <= $i; $y++){
        echo "* &nbsp;&nbsp;";  
    }
    echo "<br>";
}
?>
</body>
</html>