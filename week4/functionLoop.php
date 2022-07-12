<!DOCTYPE html>
<html>

<head>
</head>

<body>

    <?php

    date_default_timezone_set("Asia/Kuala_Lumpur");

    function generateDate($date)
    {

        $year  = substr($date, 0, 4);
        $month = substr($date, 5, 2);
        $day   = substr($date, 8, 2);

        $tyear = date("Y");
        $tmonth = date("m");
        $tday = date("d");

        echo '<select id="day">';
        if ($date == null) {
            echo "<option> $tday </option>";
        } else {
            echo "<option> $day </option>";
        }
        for ($day = 1; $day <= 31; $day++) {
            echo "<option> $day </option>";
        }
        echo '</select>';


        echo '<select id="month">';
        if ($date == null) {
            echo "<option> $tmonth </option>";
        } else {
            echo "<option> $month </option>";
        }
        for ($month = 1; $month <= 12; $month++) {
            echo "<option>" . date('m', mktime(0, 0, 0, $month)) . "</option>";
        }
        echo '</select>';


        echo '<select id="year">';
        if ($date == null) {
            echo "<option> $tyear </option>";
        } else {
            echo "<option> $year </option>";
        }
        for ($year = 1990; $year <= 2022; $year++) {
            echo "<option> $year </option>";
        }
        echo '</select>';
    }

    generateDate("2021-01-1");

    ?>

</body>

</html>