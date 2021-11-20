'use strict';

list.addEventListener('click', addToBasket);

function addToBasket(event) {
  event.preventDefault();
  if (!event.target.classList.contains('add-to-cart')) {
    return;
  }
  let item = {
    title: event.target.dataset.title,
    price: event.target.dataset.price
  };
  addToCart(item);
}
