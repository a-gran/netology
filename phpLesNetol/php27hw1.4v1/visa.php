<meta http-equiv = "content-type" content = "text/html; charset = UTF-8">

<?php

error_reporting(E_ALL);

$mainLink = 'https://data.gov.ru/opendata/7704206201-country/data-20180609T0649-structure-20180609T0649.csv?encoding=UTF-8';
$altLink = 'https://raw.githubusercontent.com/netology-code/php-2-homeworks/master/files/countries/opendata.csv';

$data = file_get_contents($mainLink) || file_get_contents($altLink);