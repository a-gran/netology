<?php

ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

$continents = [
    'Africa'        => ['Bitis',
                      'Pristiophorus nudipinnis',
                      'Asio capensis',
                      'Lybiidae',
                      'Poelagus marjorita'],
    'Australia'     => ['Pelecanus conspicillatus',
                      'Pristiophorus nudipinnis',
                      'Austrocheirus',
                      'Corvus coronoides',
                      'Indopacetus pacificus'],
    'South America' => ['Onychorhynchus coronatus',
                      'Mustela africana',
                      'Alouatta nigerrima',
                      'Amazona',
                      'Amazonetta brasiliensis']
];

// массив животных из двух слов
$twoWordsAnimals = [];
foreach ($continents as $animals) {
    foreach ($animals as $key => $animal) {
        $count = substr_count($animal, ' ');
        if ($count === 1) {
            array_push($twoWordsAnimals, $animal);
        }
    }
}

// массив выдуманных животных
$fanAnimals = [];
while (count($twoWordsAnimals) !== 0) {
    // Если осталось одно животное, то сразу отправляем его в $fanAnimals
    if (count($twoWordsAnimals) === 1) {
        array_push($fanAnimals, $twoWordsAnimals[0]);
        break;
    } else {
        // записываем первый элемент массива и случайный элемент массива, не равный первому
        $first = 0;
        $rand = rand(1, count($twoWordsAnimals) - 1);
        $firstElem = $twoWordsAnimals[$first];
        $randElem = $twoWordsAnimals[$rand];
        // Перемешиваем
        $fanFirst = substr($firstElem, 0, strpos($firstElem, ' ')) . ' '
            . substr($randElem, strpos($randElem, ' '));
        $fanSecond = substr($randElem, 0, strpos($randElem, ' ')) . ' '
            . substr($firstElem, strpos($firstElem, ' '));
        // собираем в массив получившихся животных, а из $twoWordsAnimals удаляем использованные элементы
        array_push($fanAnimals, $fanFirst, $fanSecond);
        unset($twoWordsAnimals[$first], $twoWordsAnimals[$rand]);
        // ключи по умолчанию
        $twoWordsAnimals = array_values($twoWordsAnimals);
    }
}

// изначальные места животных
$fanAnimalsContinents = [];
foreach ($fanAnimals as $elem) {
    $words1 = explode(' ', $elem);
    foreach ($continents as $key => $animal) {
        foreach ($animal as $value) {
            $words2 = explode(' ', $value);
            if ($words1[0] === $words2[0]) {
                $fanAnimalsContinents[$key][] = $elem;
            }
        }
    }
}

foreach ($continents as $key => $item) $home[] = $key;
foreach ($fanAnimalsContinents as $key => $animals) $arrAnimals[$key] = $animals;
$home = array_flip($home);
$fanAnimalsContinents = array_merge($home, $arrAnimals);

// выведение названий животных вместе с запятой
function printAnimals($array) {
    foreach ($array as $key => $animals) {
        echo "<div class=\"container\">";
        echo "<h3>{$key}</h3>";
        $animalsWithCom = implode(",<br>", $animals);
        echo "<p>{$animalsWithCom}</p>";
        echo "</div>";
    }
}

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Перемешивание животных</title>
</head>
<body>
  <div>
    <h2>Названия животных до перемешивания</h2>
    <div>
      <?php printAnimals($continents); ?>
    </div>
      <h2>Названия животных после перемешивания</h2>
    <div>
      <?php printAnimals($fanAnimalsContinents); ?>
    </div>
  </div>
</body>
</html>