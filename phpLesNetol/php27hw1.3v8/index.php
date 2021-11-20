<meta http-equiv="content-type" content="text/html; charset=utf-8">

<?php

ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

$animals = 'animals.json';
$continents = getDataFromJSON($animals);

$mixingAnimalsAcrossContinents = [
    'source' => [],
    'data' => [],
];

foreach ($continents as $continent => $arrayAnimals) {
    $mixingAnimalsAcrossContinents['source'][$continent] = [];
    foreach ($arrayAnimals as $animal) {
        $nameMoreOneWord = substr_count($animal, ' ');
        if ($nameMoreOneWord) {
            list($firstWord, $secondWord) = explode(' ', $animal);
            $mixingAnimalsAcrossContinents['source'][$continent][] = $firstWord;
            $mixingAnimalsAcrossContinents['data'][] = $secondWord;
        }
    }
}

function getDataFromJSON($animalsNames) {
    if (!is_file($animalsNames)) {
        exit("$animalsNames не является файлом");
    } elseif (!is_readable($animalsNames)) {
        exit("Нет прав на чтение $animalsNames");
    }
    $dataJSON = file_get_contents($animalsNames);
    return ((array) json_decode($dataJSON));
}

shuffle($mixingAnimalsAcrossContinents['data']);

echo '<h1>Жестокое обращение с животными!</h1>';

foreach ($mixingAnimalsAcrossContinents['source'] as $continent => $firstWords) {
    echo '<h2>', "Континент: $continent", '</h2>';
    $total = [];
    foreach ($firstWords as $firstWord) {
        if (count($mixingAnimalsAcrossContinents['data'])) {
            $total[] = $firstWord . ' ' . array_pop($mixingAnimalsAcrossContinents['data']);
        }
    }
    echo '<p>', implode(', ', $total), '</p>';
}
