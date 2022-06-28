<!DOCTYPE html>
<html>

<head>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <title>Half Diamond</title>

</head>

<body>

<?php
for ($i = 1; $i < 6; $i++) {
    for ($y = 0; $y < $i; $y++) {
    } 
    if($i % 2 == 0){

        for($x = 0; $x < $i; $x++)
            echo "-";

    }else{

        for($x = 0; $x < $i; $x++)
            echo "*";
    }
    echo "<br>";
}

for ($i = 4; $i > 0; $i--) {
    for ($y = 0; $y < $i; $y++) {
    } 
    if($i % 2 == 0){

        for($x = 0; $x < $i; $x++)
            echo "-";

    }else{

        for($x = 0; $x < $i; $x++)
            echo "*";
    }
    echo "<br>";
}
?>

</body>
</html>