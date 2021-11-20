fetch('https://neto-api.herokuapp.com/cart/colors', {
  method: 'get'
}).then(function(response) {
    return response.json();
  }).then(function(data) {
    const colorSwatch = document.querySelector('#colorSwatch');
    data.forEach(function (item) {
      let available;
      let checked;
      if (item.isAvailable) {
        available = 'available';
        checked = 'checked';
      } else {
        available = 'soldout';
        checked = 'disabled';
      }
      colorSwatch.innerHTML += `
        <div data-value="${item.type}" class="swatch-element color ${item.type} ${available}">
          <div class="tooltip">${item.title}</div>
          <input quickbeam="color" id="swatch-1-${item.type}" type="radio" name="color" value="${item.type}" ${checked}>
          <label for="swatch-1-${item.type}" style="border-color: red;">
            <span style="background-color: ${item.code};"></span>
            <img class="crossed-out" src="https://neto-api.herokuapp.com/hj/3.3/cart/soldout.png?10994296540668815886">
          </label>
        </div>`
    })
  });

fetch('https://neto-api.herokuapp.com/cart/sizes', {
  method: 'get'
}).then(function(response) {
    return response.json();
  }).then(function(data) {
    const sizeSwatch = document.querySelector('#sizeSwatch');
    data.forEach(function (item) {
      let available;
      let checked;
      if (item.isAvailable) {
        available = 'available';
        checked = 'checked';
      } else {
        available = 'soldout';
        checked = 'disabled';
      }
      sizeSwatch.innerHTML += `
        <div data-value="${item.type}" class="swatch-element plain ${item.type} ${available}">
          <input id="swatch-0-${item.type}" type="radio" name="size" value="${item.type}" ${checked}>
          <label for="swatch-0-${item.type}">
            ${item.title}
            <img class="crossed-out" src="https://neto-api.herokuapp.com/hj/3.3/cart/soldout.png?10994296540668815886">
          </label>
        </div>`
    })

    if (localStorage.index) {
      const arrayIndex = JSON.parse(localStorage.index),
      inputsamples = document.querySelectorAll('.samples input');
      arrayIndex.forEach(function (item) {
        inputsamples[item].checked = true;
      })
    }
  });

function storeBasket(data) {
  const fastBasket = document.querySelector('#quick-cart');
  let priceSum = 0;
  data.forEach(function (item) {
    fastBasket.innerHTML = `
      <div class="quick-cart-product quick-cart-product-static" id="quick-cart-product-${item.id}" style="opacity: 1;">
        <div class="quick-cart-product-wrap">
          <img src="${item.pic}" title="${item.title}">
          <span class="s1" style="background-color: #000; opacity: .5">$${item.price}</span>
          <span class="s2"></span>
        </div>
        <span class="count hide fadeUp" id="quick-cart-product-count-${item.id}">${item.quantity}</span>
        <span class="quick-cart-product-remove remove" data-id="${item.id}"></span>
      </div>`;
    priceSum = item.price * item.quantity;
  })
  fastBasket.innerHTML += `
    <a id="quick-cart-pay" quickbeam="cart-pay" class="cart-ico open">
      <span>
        <strong class="quick-cart-text">Оформить заказ<br></strong>
        <span id="quick-cart-price">${priceSum}</span>
      </span>
    </a>`
  const fastBasketPay = document.querySelector('#quick-cart-pay');
  (data.length === 0) ? fastBasketPay.classList.remove('open') : fastBasketPay.classList.add('open');
  const remove = document.querySelector('.remove');
  remove.addEventListener('click', isCartEmpty);
}

fetch('https://neto-api.herokuapp.com/cart', {
  method: 'get'
}).then(function(response) {
    return response.json();
  }).then(function(data) {
    storeBasket(data);
  });

function isCartEmpty() {
  const remove = document.querySelector('.remove');
  const fastBasket = document.querySelector('#quick-cart');
  const formData = new FormData(); 
  formData.append('productId', remove.dataset.id);
  console.log(remove.dataset.id)
  fetch('https://neto-api.herokuapp.com/cart/remove', {
    method: 'post',
    body: formData
  }).then(function(response) { 
      return response.json();
    }).then(function(data) {
      (data.length > 0) ? storeBasket(data) : fastBasket.innerHTML = '';
    });
}
const samples = document.querySelector('.samples');
samples.addEventListener('click', pick);

function pick(event) {
  const inputSamples = document.querySelectorAll('.samples input'),
  arrayInputSamples = Array.from(inputSamples),
  arrayIndex = []; 
  arrayInputSamples.forEach(function (item, i) {
    if (item.checked) {
      arrayIndex.push(i);
    }
  })
  localStorage.index = JSON.stringify(arrayIndex);
}
const addToCard = document.querySelector('#AddToCart');
addToCard.addEventListener('click', query);

function query(event) {
  const AddToCartForm = document.querySelector('#AddToCartForm'),
  formData = new FormData(AddToCartForm);  
  formData.append('productId', AddToCartForm.dataset.productId);
  fetch('https://neto-api.herokuapp.com/cart', {
    method: 'post',
    body: formData
  }).then(function(response) { 
      return response.json();
    }).then(function(data) {
      storeBasket(data);
    });
  event.preventDefault();
}
