'use strict';

const idIncrement = document.querySelector('#increment');
const idDecrement = document.querySelector('#decrement');
const zeroingCount = document.querySelector('#reset');
const counter = document.querySelector('#counter');

function scorer (ev) {
  let count = localStorage.getItem('count');
  if (ev.target.id === 'increment') {
    counter.textContent = ++count;
    idDecrement.disabled = false;
  }
  if ((ev.target.id === 'decrement') && !idDecrement.disabled) {
    counter.textContent = --count;
  }
  count === 0 ? idDecrement.disabled = true : idDecrement.disabled = false;
  localStorage.setItem('count', count); 
}

function zeroingCounter () {
  localStorage.setItem('count', 0);
  counter.textContent = localStorage.getItem('count');
  idDecrement.disabled = true;
}

localStorage.getItem('count') ? counter.textContent = localStorage.getItem('count') : localStorage.setItem('count', 0);
localStorage.getItem('count') === '0' ? idDecrement.disabled = true : idDecrement.disabled = false;
zeroingCount.addEventListener('click', zeroingCounter);
idIncrement.addEventListener('click', scorer);
idDecrement.addEventListener('click', scorer);