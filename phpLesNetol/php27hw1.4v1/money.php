<meta http-equiv = "content-type" content = "text/html; charset = UTF-8">

<?php

error_reporting(E_ALL);

//var_dump($argv);

echo '<br><br>';

$data = file("./purchases.csv", FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

for($i = 0; $i < count($data); $i++) {
  echo $data[$i]."\n";
}


