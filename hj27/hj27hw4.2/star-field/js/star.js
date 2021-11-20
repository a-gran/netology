'use strict'

let canvas = document.querySelector('canvas');
let ctx = canvas.getContext('2d');
canvas.addEventListener('click', updateScreen);
updateScreen();

function updateScreen() {
  ctx.fillStyle = 'black';
  ctx.fillRect(0, 0, canvas.width, canvas.height);
  for (let i = 1; i <= rand(200, 400); i++) {
    let x = random(0, canvas.width);
    let y = random(0, canvas.height);
    let r = random(0, 1.1);
    let alpha = random(0.8, 1);
    let color = randomColor();
    ctx.beginPath();
    ctx.fillStyle = color;
    ctx.globalAlpha = alpha;
    ctx.arc(x, y, r, 0, 2 * Math.PI);
    ctx.fill();
  }
}

function rand(from, to) {
  return Math.round(random(from, to));
}

function random(from, to) {
  return (from + ( Math.random() * (to - from)));
}

function randomColor() {
  let randomColor = random(0, 3) 
    if (randomColor < 1) {
      return '#ffffff';
    } else if (randomColor < 2 ) {
      return '#d4fbff';
    } else {
      return '#ffe9c4';
    }
}