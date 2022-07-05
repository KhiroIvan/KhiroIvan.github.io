<!DOCTYPE html>
<html>
<head>
</head>
<body>
<?php
function generateStars($star,$dash) {
    return [$star,$dash];
  }
  
  [$star,$dash] = generateStars ("-","*");
  
  
  echo "<pre>";
  for ($i = 1; $i <= 5; $i++) {
    for ($j = $i; $j <= 5; $j++)
        echo " ";
    for ($j = $i  ; $j >= 1; $j--)
          if($i % 2 == 0){
              echo $star;   
          }else{
              echo $dash;
          }
      echo "<br>";
  }
  
  
  for ($i = 4; $i >= 0; $i--) {
    for ($j = $i; $j <= 5; $j++)
        echo " ";
    for ($j = $i  ; $j >= 1; $j--)
          if($i % 2 == 0){
              echo $star;   
          }else{
              echo $dash;
          }
      echo "<br>";
  }
?>

</body>
</html>