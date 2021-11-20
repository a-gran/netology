<?php 
  $userName      = 'Алексей';
  $userLastName  = 'Шрамко';
  $userAge       = 34;
  $userEmail     = 'alex-shtern@yandex.ru';
  $userPhone     = '+7(918)222-63-22';
  $userCity      = 'Краснодар';
  $userAbout     = 'Верстальщик';
?>

<!DOCTYPE html>
<html lang="ru">
<head>
  <meta charset="UTF-8">
  <link rel="stylesheet" href="main.css">
  <title><?= $userLastName.' '.$userName;  ?></title>
</head>
<body>

  <section>
    <h1>Страница пользователя <?= $userLastName.' '.$userName;  ?></h1>
    <div class="wrap">
      <dl>
        <dt>Имя:</dt>
        <dd><?= $userName;  ?></dd>
      </dl>
      <dl>
        <dt>Фамилия:</dt>
        <dd><?= $userLastName;  ?></dd>
      </dl>
      <dl>
        <dt>Возраст (полных лет):</dt>
        <dd><?= $userAge;  ?></dd>
      </dl>
      <dl>
        <dt>Адрес электронной почты:</dt>
        <dd><a  href="mailto: <?= $userEmail ?> "><?= $userEmail;  ?></a></dd>
      </dl>
      <dl>
        <dt>Номер мобильного телефона:</dt>
        <dd><?= $userPhone;  ?></dd>
      </dl>
      <dl>
        <dt>Город:</dt>
        <dd><?= $userCity;  ?></dd>
      </dl>
      <dl>
        <dt>О себе:</dt>
        <dd><?= $userAbout;  ?></dd>
      </dl>
    </div>
  </section>
  
</body>
</html>



<?php
// дополнительное задание
echo '<br><br>';

$userNumber = rand(0, 100);
echo 'Число пользователя '.$userNumber.'<br>';

$firstVar = 1;
echo 'Первая переменная - число '.$firstVar.'<br>';

$secondVar = 2;
echo 'Вторая переменная - число '.$secondVar.'<br>';

do {
    if($firstVar < $userNumber) {
        $threeVar = $firstVar;
        $firstVar = $firstVar + $secondVar;
        $secondVar = $threeVar;
    } else {
        break;
    }
} while(true);

if ($firstVar > $userNumber) {
    echo ' Задуманное число НЕ входит в числовой ряд';
} elseif ($firstVar == $userNumber) {
    echo ' Задуманное число входит в числовой ряд';
}

?>

