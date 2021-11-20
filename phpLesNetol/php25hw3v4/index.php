<meta http-equiv="content-type" content="text/html; charset=utf-8">

<?php
error_reporting(E_ALL);

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

echo '<pre>';
print_r($continents);
echo '</pre>';

echo '<br>'.'<br>';
foreach ($continents as $continent => $animals) {
    foreach ($animals as $animal) {
        if(strpos($animal, ' ') == true) {
            for ($i=0; $i < count($animal); $i++) {
                $twoWordsAnimals[] = $animal;
                }
           }
       }
   }

echo '<pre>';
var_dump($twoWordsAnimals);
echo '</pre>';

?>