<!DOCTYPE html>
<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Loop</title>
</head>

<body>
<select name="Day">
        <?php
	        for($day = 1; $day <= 30; $day++){
		       echo "<option value = '".$day."'>".$day."</option>";
		}
	?>
</select>

<select name="Month">
	<?php
		for($i=19;$i<=30;$i++){
            $month=date('F',strtotime("first day of $i month"));
            echo "<option value=$month>$month</option> ";
        }
	?>
</select>

<select name="Year">
	<?php
		$y = date("Y");
		for($year = 1990; $y >= $year; $y--){
			echo "<option value = '".$y."'>".$y."</option>";
		}
	?>
</select>
</body>
</html>