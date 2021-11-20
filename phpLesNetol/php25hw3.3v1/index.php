<meta http-equiv="content-type" content="text/html; charset=utf-8">

<?php

ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

spl_autoload_register(
    function($className) {
		    $path = rtrim(__DIR__, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR ;
        $fullPath = $path . str_replace('\\', DIRECTORY_SEPARATOR, $className) . '.php';
		    if (file_exists($fullPath)) {
			      require $fullPath;
		    }
	  }
);
// Класс Автомобиль
echo '<h4>Автомобиль</h4>';
$audi = new Products\Category\Car('автомобиль', 50000);
$audi->setMake('audi');
$audi->setModel('R8');
$audi->setColor('красный');

// Корзина
$basket = new Products\Basket();
$basket[] = $vaz;
$samsung->setPrice(NULL);

$basket[] = $audi;

echo "<h2>В корзине товаров на общую сумму: {$basket->getPriceProductsBasket()} руб.</h2>";
// Заказ
$order = new Products\Order($basket);
$order->getInfoOrder();