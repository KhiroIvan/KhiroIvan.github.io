<!DOCTYPE html>
<html>
<head>
</head>

<body>
<?php
$num = array(3, 6, 2, 45, 34, 63, 4, 63, 76, 21);
$oddArray = array();
$evenArray = array();
$total = 0;
$totalOdd = 0;  
$totalEven = 0;

echo " Original array: ";
for ($i = 0; $i < sizeof($num); $i++) {
    if($i != sizeof($num)-1){
        echo "$num[$i] / ";
    }else{
        echo "$num[$i]";
    }
    $total = $total + $num[$i];
} 
echo "<br>";

$j = 0;
$k = 0;

for ($i = 0; $i < sizeof($num); $i++) {
    if ($num[$i] % 2 == 0) {
        $evenArray[$j] = $num[$i];
        $j++;
    } else {
        $oddArray[$k] = $num[$i];
        $k++;
    }
}

echo "  Even numbers in Array : ";

for ($i = 0; $i <= $j-1; $i++) {
    if($i != sizeof($evenArray)-1) {
        echo "$evenArray[$i] / ";
    }else{
        echo "$evenArray[$i]";
    }
    
    $totalEven = $totalEven + $evenArray[$i];
}
echo "<br>";

echo " Odd numbers in Array : ";

for ($i = 0; $i <= $k-1; $i++) {
    if($i != sizeof($oddArray)-1) {
        echo "$oddArray[$i] / ";
    }else{
        echo "$oddArray[$i]";
    }
    $totalOdd = $totalOdd + $oddArray[$i];
}

echo "<br>";

echo "Total All: ",$total ,"<br>";
echo "Total Even: ",$totalEven,"<br>";
echo "Total Odd: ",$totalOdd,"<br>";
?>

</body>
</html>