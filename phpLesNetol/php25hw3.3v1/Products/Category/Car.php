<?php
namespace Products\Category;
use Products\Product;
class Car extends Product
{
	  private $color = 'не указан';
		public function setColor($color)
		{
        $this->color = $color;
		}
		public function printDescription()
		{
			  echo '<b>, цвет:</b> '.$this->color;
		}
}