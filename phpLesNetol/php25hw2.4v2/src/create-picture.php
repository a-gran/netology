<?php

header('Content-type: image/png');

$testname = $_POST['testname'];
$username = $_POST['username'];
$date = $_POST['date'];
$correctAnswers = $_POST['correctAnswers'];
$totalAnswers = $_POST['totalAnswers'];

$answers = $correctAnswers . ' из ' . $totalAnswers;

// Создаем картинку, размер и цвет шрифта
$img = imagecreatefromjpeg('img/picture.jpg');
$white = imagecolorallocate($img, 035, 035, 035);

// Определяем положение имени пользователя (по центру)
$imageWidth = getimagesize('img/picture.jpg');
$imageWidth = $imageWidth[0];
$textPoints = imagettfbbox(300, 0, 'fonts/OpenSans.ttf', $username);
$textWidth = $textPoints[2] - $textPoints[0];
$x = ($imageWidth - $textWidth) / 2;

// Распологаем все данные на картинке
imagettftext($img, 300, 0, $x, 700, $white, 'fonts/OpenSans.ttf', $username . ',');
imagettftext($img, 200, 0, 1600, 1625, $white, 'fonts/OpenSans.ttf', $testname);
imagettftext($img, 180, 0, 1600, 1976, $white, 'fonts/OpenSans.ttf', $answers);
imagettftext($img, 180, 0, 1600, 2325, $white, 'fonts/OpenSans.ttf', $date);

// Возвращаем картинку
imagepng($img);
imagedestroy($img);