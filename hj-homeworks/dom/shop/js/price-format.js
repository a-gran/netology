'use strict';

let box = document.getElementsByClassName('box'); 
let items = document.getElementsByClassName('add');
let cartCount = document.getElementById('cart-count');
let cartTotalPrice = document.getElementById('cart-total-price');

let totalPrice = 0;

for(let item of items){
  item.addEventListener('click', addProduct); 
}

function getPriceFormatted(value) {
  return  value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ' ');
}

function addProduct() {
  let currentPrice = this.dataset.price;
  totalPrice += +this.dataset.price;
  cartTotalPrice.innerHTML = getPriceFormatted(totalPrice)
  cartCount.innerHTML = +cartCount.innerHTML + 1;
}