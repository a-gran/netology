<?php 
  $userName      = 'Алексей';
  $userLastName  = 'Шрамко';
  $userAge       = 34;
  $userEmail     = 'alex-shtern@yandex.ru';
  $userPhone     = '+7(918)172-63-20';
  $userCity      = 'Краснодар';
  $userAbout     = 'Верстальщик';
?>

<!DOCTYPE html>
<html lang="ru">
<head>
  <meta charset="UTF-8">
  <link rel="stylesheet" href="main.css">
  <title><?= $userLastName." ".$userName;  ?></title>
</head>
<body>

  <section>
    <h1>Страница пользователя <?= $userLastName." ".$userName;  ?></h1>
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

