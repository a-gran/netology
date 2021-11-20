<?php
namespace Products;
abstract class Product
{
		protected $title;
		protected $price;
		protected $make = 'не указан';
		protected $model = 'не указана';
		public static $staticProperty = 0;
		public function __construct($title, $price)
		{
				$this->title = $title;
				$this->price = $price;
				self::$staticProperty++;
		}
		public function getProperty()
		{
			  echo self::$staticProperty;
		}
		public function setTitle($title)
		{
			  $this->title = $title;
		}
		public function setPrice($price)
		{
			  $this->price = $price;
		}
		public function setMake($make)
		{
			  $this->make = $make;
		}
		public function setModel($model)
		{
			  $this->model = $model;
		}
		public function getPrice()
		{
			  return $this->price;
		}
		public function printFullDescription()
		{
				echo '<b>наименование товара:</b> '.$this->title.', <b>производитель:</b> '.$this->make.', <b>модель:</b> '.$this->model.', <b>цена:</b> '.$this->getPrice().' руб.';
				$this->printDescription();
		}
		abstract public function printDescription();
}