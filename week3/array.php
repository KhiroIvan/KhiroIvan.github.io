<!DOCTYPE html>
<html>

<head>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <title>Array</title>

</head>

<body>

<?php
$Num = array(3, 6, 2, 45, 34, 63, 4, 63, 76, 21);

$odd = array();
$even = array();
$total = 0;
$totalodd = 0; 
$totaleven = 0;

echo "Orginal array:";
$size = count($Num);
for ($i = 0; $i < $size; $i++) {
    echo "$Num[$i] "," / ";
    $total = $total + $Num[$i];
}

echo "<br>";

$x = 0;
$y = 0;
for ($i = 0; $i < $size; $i++) {
    if ($Num[$i] % 2 == 0) {
        $even[$x] = $Num[$i];
        $x++;
    } else {
        $odd[$y] = $Num[$i];
        $y++;
    }
}
?>

<?php
echo "Array of even numbers : ";
for ($i = 0; $i <= $y; $i++) {
    echo "$even[$i] "," / ";
    $totaleven = $totaleven + $odd[$i];
}
?>

<?php
echo "Array of odd numbers : ";
for ($i = 0; $i <= $x; $i++) {
    echo "$odd[$i] "," / ";
    $totalodd = $totalodd + $odd[$i];
}

echo "<br>";
echo "Total All: ", $total ,"<br>";
echo "Total Even: ", $totaleven ,"<br>";
echo "Total Odd: ", $totalodd ,"<br>";
?>

</body>
</html>