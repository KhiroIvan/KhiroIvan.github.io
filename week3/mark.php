<!DOCTYPE html>
<html>
<body>

<?php
$mark = 74;
var_dump($mark);

if ($mark >= 80) {
	echo "Distinction";
} elseif ($mark >= 60) {
	echo "Good";
} elseif ($mark >= 40) {
	echo "Pass";
} else { 
	echo "Fail";
}

?>
 
</body>
</html>
