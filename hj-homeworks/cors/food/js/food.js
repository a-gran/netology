'use strict';

let foodUrl = 'https://neto-api.herokuapp.com/food/42';
let ratingUrl = 'https://neto-api.herokuapp.com/food/42/rating';
let consumersUrl = 'https://neto-api.herokuapp.com/food/42/consumers';

function food(data) {
  let title = document.querySelector('[data-title]');
  let pic = document.querySelector('[data-pic]');
  let ingredients = document.querySelector('[data-ingredients]');

  title.textContent = data.title;
  pic.style.background = `url(${data.pic}) no-repeat`;
  ingredients.textContent = data.ingredients.join(', ');

  return ratingUrl;
}

function dataUpload(url) {
  let callback = 'callback';
  return new Promise((done, fail) => {
      window[callback] = done;
      let script = document.createElement('script');
      script.src = `${url}?jsonp=${callback}`;
      document.body.appendChild(script);
  });
}

function user(data) {
  let dataConsumers = document.querySelector('[data-consumers]');
  let span = document.createElement('span');
  Array.from(data.dataConsumers).forEach(element => {
      dataConsumers.appendChild(document.createElement('img'));
      dataConsumers.lastElementChild.src = element.pic;
      dataConsumers.lastElementChild.setAttribute('title', element.name);
  });
  dataConsumers.appendChild(span);
  dataConsumers.lastElementChild.textContent = `(+${data.total})`;
}

function rating(data) {
  let rating = document.querySelector('[data-rating]');
  let star = document.querySelector('[data-star]');
  let votes = document.querySelector('[data-votes]');
  rating.textContent = data.rating;
  star.style.width = `${data.rating *10}%`;
  votes.textContent = `${data.votes} оценок`;
  return consumersUrl;
}

dataUpload(foodUrl).then(food)
  .then(res => dataUpload(res)).then(rating)
    .then(res => dataUpload(res)).then(user)
      .catch(error => { console.log(error) });