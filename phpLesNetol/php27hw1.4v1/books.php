<meta http-equiv = "content-type" content = "text/html; charset = UTF-8">

<?php

error_reporting(E_ALL);

$link = 'https://www.googleapis.com/books/v1/volumes?q={query}';

$data = file_get_contents($link);