<?php
namespace Products;
class Basket  implements \ArrayAccess
{
	  public $container = [];
		public function offsetSet($index, $product)
		{
				try {
            if (empty($product->getPrice())) {
					      throw new MyException('<b>Ошибка!</b> ');
				    }
            if (is_null($index)) {
					      $this->container[] = $product;
				    } else {
					      $this->container[$index] = $product;
				    }
				} catch (MyException $e) {
					  echo $e->getMessage(), '<b>У товара - </b> ', $product->printFullDescription(), '<b> отсутствует значение - цена!';
				}			
		}
		public function offsetGet($index)
		{
			  return isset($this->container[$index]) ? $this->container[$index] : null;
		}
		public function offsetExists($index)
		{
			
			  return isset($this->container[$index]);
		}
		public function offsetUnset($index)
		{
		    unset($this->container[$index]);
		}
		public function getPriceProductsBasket()
		{
			  $totalPrice = 0;
			  foreach ($this->container as $product) {
					  $totalPrice = $totalPrice + $product->getPrice();
				}
				return $totalPrice;
		}
}