<?php
class CarType
{
    public $model;
    public $color;
    public $price;
}

class Car extends CarType
{
    public function getCar()
    {
        $html = $this->model . ' ' . $this->color . ' ' . $this->price;
        return $html;
    }
}

$audi = new Car();
$audi->model = 'Audi';
$audi->color = 'white';
$audi->price = '1 000 000';

$toyota = new Car();
$toyota->model = 'Toyota';
$toyota->color = 'black';
$toyota->price = '500 000';

class TV
{
    public $price;
    public $diagonal = 24;
    public function price()
    {
        
    }
}
$dell = new TV();
$samsung = new TV();

class BallPen
{
    public $model;
    public $color;
    public $price;

    public function getPen()
    {
        echo $this->model . ' ' . $this->color . ' ' . $this->price;
    }
}

$penParker = new BallPen();
$penParker->model = 'Parker';
$penParker->color = 'blue';
$penParker->price = 100;

$penErichKrause = new BallPen();
$penErichKrause->model = 'ErichKrause';
$penErichKrause->color = 'Black';
$penErichKrause->price = 50;

class Duck
{
    public $weight;
    public $breed;
    public $color = 'grey';
    public function color()
    {
      
    }
}
$blackDuck = new Duck();
$greyDuck = new Duck();

class Product
{
    public $type;
    public $price;
    public $weight;
    public function price()
    {
      
    }
}
$nokia = new Product();
$samsung = new Product();
?>