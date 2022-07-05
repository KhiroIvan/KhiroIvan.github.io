<!DOCTYPE html>
<html>
<head>
</head>
<body>

<?php

$day = date('d');
$month = date('F');
$year = date('Y');


echo '<select id="day">';
echo "<option> $day </option>";
for($day = 1; $day <= 31; $day++){
    echo "<option> $day </option>"; 
  
}
echo '</select>';


echo '<select id="month">';
echo "<option> $month </option>";
for($month = 1; $month <= 12; $month++){
    echo "<option>". date('F', mktime(0,0,0,$month))."</option>" ;
}
echo '</select>';


echo '<select id="year">';
echo "<option> $year </option>";
for($year = 1990; $year <= 2022; $year++){
    echo "<option> $year </option>"; 
}
echo '</select>';

?>
 
</body>
</html>