<?php
namespace Products;
class Order
{
    private $order;
	  public function __construct(Basket $basket)
		{
        $this->order = $basket;
		}
    public function getInfoOrder()
		{
			  $i = 1;
			  foreach ($this->order->container as $key=>$product) {
						echo "<h3>Товар: {$i}</h3>";
						$this->order[$key]->printFullDescription();
						$i++;
						echo '<br>';
			  } 
		}
}