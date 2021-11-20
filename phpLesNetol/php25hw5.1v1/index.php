<?php

require_once 'src/Address.php';

if (!empty($_GET['find'])) {

    $geo = new \Address;
    $result = $geo->findCoords($_GET['find']);

    foreach ($result as $key => $item) {
        $array[$key]['address'] = $item->getAddress();
        $array[$key]['pos'] = $item->getLatitude() . ' ' . $item->getLongitude();
    }
}

?>

<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css"
          integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
    <script src="https://api-maps.yandex.ru/2.1/?lang=ru_RU"></script>
    <title>HW 5.1</title>
</head>
<body style="background-color: lightgoldenrodyellow;">
<div class="container">
    <div id="map" class="col-md-6 offset-md-3"
         style="height: 300px; margin-top: 40px; padding: 0; border: 1px solid rgba(0,0,0,.165);"></div>

    <form method="get" class="container">
        <div class="row">
            <div style="margin-top: 40px" class="col-md-6 offset-md-3">
                <div class="input-group">
                  <span class="input-group-btn">
                    <button class="btn btn-secondary" type="submit">Найти</button>
                  </span>
                    <input type="text" class="form-control" placeholder="Введите адрес..." name="find">
                </div>
            </div>
        </div>
    </form>

    <?php if (!empty($array)): ?>
        <div class="col-md-6 offset-md-3" style="margin-bottom: 40px;">
            <?php foreach ($array as $item): ?>
                <a href="<?php echo 'index.php?find=' . urlencode($_GET['find']) . '&result=' . urlencode($item['pos']); ?>"
                   class="list-group-item result">
                    <h4 class="list-group-item-heading col-md-12"><?php echo $item['pos'] ?></h4>
                    <p class="list-group-item-text col-md-12" style="margin-bottom: 0;"><?php echo $item['address'] ?></p>
                </a>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<script src="https://code.jquery.com/jquery-3.2.1.js"></script>
<script src="index.js"></script>
</body>
</html>
