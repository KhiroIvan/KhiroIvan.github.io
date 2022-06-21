<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="css/style.css" rel="stylesheet" type="text/css"/>
    <title>date</title>
</head>

<body>

<div id="container">
    <div id="starting">
        <div class="first">
            <?php
            echo date("d");
            ?>
        </div>

        <br>

        <div class="second">
            <?php
            echo date("M Y");
            ?>
        </div>
    </div>
    <!--the end of starting-->
    <br />

    <div id="middle">
        <div class="third">
            <?php
            echo date("d");
            ?>
        </div>

        <div class="fourth">
            <?php
            echo date("M Y");
            ?>
        </div>
    </div>
    <!--the end of middle-->
    

    <div id="last">
        <div class="fifth">
            <?php
            echo date("d");
            ?>
        </div>

        <div class="sixth">
            <?php
            echo date("M");

            echo "<br>";

            echo date("Y");
            ?>

        </div>
    </div>
    <!--the end of last-->

    </div><!--the end of container-->

</body>

</html>