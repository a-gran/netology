'use strict';

let tasks = document.querySelector('.list-block');
let output = tasks.querySelector('output');
let boxes = tasks.querySelectorAll('input');
let h3 = document.querySelector('h3');
let counter = 0;

for (let box of boxes) {
  box.addEventListener('click', taskCheked);
  box.checked = false;
  if (box.checked) {
    ++counter;
  }
  outputVal();
}

function outputVal() {
  output.value = `${counter} из ${boxes.length}`;
}

function taskCheked() {
  this.checked ? ++counter : --counter;
  counter === 4 ? tasks.classList.add('complete') :  tasks.classList.remove('complete');
  outputVal();
}