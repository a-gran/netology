<?php

ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

class CarType
{
    public $model;
    public $color;
    public $price;
    public function __construct ($model, $color, $price) {
        $this -> model = $model;
        $this -> color = $color;
        $this -> price = $price;
    }
}

class Car extends CarType
{
    public function getCar()
    {
        $html = $this->model . ' ' . $this->color . ' ' . $this->price;
        return $html;
    }
}

$audi = new Car('Audi', 'white', '1 000 000');
$toyota = new Car('Toyota', 'black', '500 000');

class Tv
{
    public $mark;
    public $diagonal;
    public $price;
    public function __construct ($mark, $diagonal, $price) {
        $this -> mark = $mark;
        $this -> diagonal = $diagonal;
        $this -> price = $price;
    }
    public function getTv()
    {
        $html = $this->mark . ' ' . $this->diagonal . ' ' . $this->price;
        return $html;
    }
}

$dell = new Tv('DELL', '24', '10 000');
$samsung = new Tv('Samsung', '27', '20 000');

class BallPen
{
    public $model;
    public $color;
    public $price;
    public function __construct ($model, $color, $price) {
        $this -> model = $model;
        $this -> color = $color;
        $this -> price = $price;
    }
    public function getBallPen()
    {
        echo $this->model . ' ' . $this->color . ' ' . $this->price;
    }
}

$penParker = new BallPen('Parker', 'Blue', '100');
$penErichKrause = new BallPen('ErichKrause', 'Black', '50');

class Duck
{
    public $breed;
    public $weight;
    public $color;
    public function __construct ($breed, $weight, $color) {
        $this -> breed = $breed;
        $this -> weight = $weight;
        $this -> color = $color;
    }
    public function getDuck()
    {
        $html = $this->breed . ' ' . $this->weight . ' ' . $this->color;
        return $html;
    }
}
$blackDuck = new Duck('Black Duck', '3', 'Black');
$greyDuck = new Duck('Grey Duck', '4', 'Grey');

class Product
{
    public $type;
    public $price;
    public $weight;
    public function __construct ($type, $price, $weight) {
        $this -> type = $type;
        $this -> price = $price;
        $this -> weight = $weight;
    }
    public function getProduct()
    {
        $html = $this->type . ' ' . $this->price . ' ' . $this->weight;
        return $html;
    }
}
$nokia = new Product('Mobile Phone', '8 000', '68');
$samsung = new Product('Mobile Phone', '17 000', '78');

?>

<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Classes</title>
</head>
<body>

<?=$toyota->getCar();?>
<?='<br>';?>
<?=$dell->getTv();?>
<?='<br>';?>
<?=$penErichKrause->getBallPen();?>
<?='<br>';?>
<?=$greyDuck->getDuck();?>
<?='<br>';?>
<?=$nokia->getProduct();?>

</body>
</html>