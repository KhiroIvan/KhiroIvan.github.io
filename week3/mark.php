<!DOCTYPE html>
<html>
<body>

<?php
$mark = 100;
var_dump($mark);

if ($mark >= 80 && $mark <= 100) {
	echo "Distinction";
    	if ($mark == 100) {
        	echo "Well Done";
        } 
} elseif ($mark >= 60 && $mark <= 79) {
	echo "Good";
    
} elseif ($mark >= 40 && $mark <= 59) {
	echo "Pass";
    
} elseif ($mark >= 0 && $mark <= 39) { 
	echo "Fail";
    
} else {
    echo "Error";
}

?>
 
</body>
</html>