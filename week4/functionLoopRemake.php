<!DOCTYPE html>
<html>

<head>
</head>

<body>

    <?php
    function dropdown($sday = "", $smonth = "", $syear = ""){

        if (empty($sday)) {
            $sday = date('d');
        }

        if (empty($smonth)) {
            $smonth = date('m');
        }

        if (empty($syear)) {
            $syear = date('Y');
        }

        //---v---select day---v---//
        echo '<select id="day">';
        for ($day = 1; $day <= 31; $day++) {
            $s = ($day == $sday) ? 'selected' : '';
            echo "<option value = $day $s> $day </option>";
        }
        echo '</select>';

        //---v---select month---v---//
        echo '<select id="month">';
        for ($month = 1; $month <= 12; $month++) {
            $s = ($month == $smonth) ? 'selected' : '';
            echo "<option value = $month $s>" . date('F', mktime(0, 0, 0, $month)) . "</option>";
        }
        echo '</select>';

        //---v---select year---v---//
        $nowyear = date('Y');
        echo '<select id="year">';
        for ($year = 1990; $year <= $nowyear; $year++) {
            $s = ($year == $syear) ? 'selected' : '';
            echo "<option value = $year $s> $year </option>";
        }
        echo '</select>';
        echo "<br>";
    }

    dropdown(12, 5, 2001);
    dropdown();


    ?>

</body>

</html>