<!DOCTYPE html>
<html>
<body>

<?php  
function generateStars($onOfStar,$star) {
    return [$onOfStar,$star];
  }
  
  [$onOfStar,$star] = generateStars ("7","*");
  $mm = $onOfStar - 3;
  
  echo "<pre>";
  
  for ($i = 1; $i <= $mm; $i++) {
      for ($row = $i; $row <= $mm; $row++)
          echo " ";
      for ($row = 2 * $i - 1; $row >= 1; $row--)
          echo $star;
      echo "<br>";
  }
  for ($i = $mm -1; $i >= 1; $i--) {
      for ($row = 5 - $i; $row >= 1; $row--)
          echo " ";
      for ($row = 2 * $i - 1; $row >= 1; $row--)
          echo $star;
      echo "<br>";
  }
?>  

</body>
</html>