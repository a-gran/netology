
<meta http-equiv="content-type" content="text/html; charset=utf-8">

<?php

$userNumber = rand(0, 100);
echo 'Число пользователя '.$userNumber.'<br>';

$firstVar = 1;
echo 'Первая переменная - число '.$firstVar.'<br>';

$secondVar = 1;
echo 'Вторая переменная - число '.$secondVar.'<br>';

do {
  if($firstVar > $userNumber) {
      echo " Задуманное число НЕ входит в числовой ряд";
      break;
      } elseif($firstVar == $userNumber) {
          echo " Задуманное число входит в числовой ряд";
          break;
      } else {
          $threeVar = $firstVar;
          $firstVar = $firstVar + $secondVar;
          $secondVar = $threeVar;
      }
} while (true);

?>