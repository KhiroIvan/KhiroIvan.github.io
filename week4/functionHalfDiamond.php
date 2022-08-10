<!DOCTYPE html>
<html>

<head>
</head>

<body>
<?php
function generateStars($m) {
  $star = "<pre>";
  for ($x = 1; $x < $m; $x++) {
    for ($y = 0; $y < $x; $y++) {
      $star = $star . "*";
    }
    $star = $star . "<br>";
  }
  for ($x = $m; $x > 0; $x--) {
    for ($y = 0; $y < $x; $y++) {
      $star = $star . "*";
    }
    $star = $star . "<br>";
  }
  return $star;
}
$star = generateStars(6);
echo $star;

?>

</body>

</html>