<?php

error_reporting(E_ALL);

$link = 'http://api.openweathermap.org/data/2.5/weather';
$apiKey = 'ef275086da6b4c2a604c04dd29f2e5dc';
$city = 'Moscow';
$units = 'metric';
$apiURL = "{$link}?q={$city}&units={$units}&appid={$apiKey}";
$weather = file_get_contents($apiURL) or exit('Не удалось получить данные');
$data = json_decode($weather, true) or exit('Ошибка декодирования json');

?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Погода</title>
</head>
<body>

<?php

$cityName = (!empty($data['name'])) ? $data['name'] : 'не удалось получить название города';
echo 'Город: ' . $cityName . '<br>';
$tempVal = (!empty($data['main']['temp'])) ? $data['main']['temp'] : 'не удалось получить значение температуры';
echo 'Температура воздуха: ' . $tempVal . '<br>';
$pressureVal = (!empty($data['main']['pressure'])) ? $data['main']['pressure'] : 'не удалось получить значение температуры';
echo 'Атмосферное давление: ' . $pressureVal . '<br>';

?>
</body>
</html>