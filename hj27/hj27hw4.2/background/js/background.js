'use strict'

let canvas = document.querySelector('canvas');
let ctx = canvas.getContext('2d');

let changeOfCoordinatesWithTime = [
  function(x, y, time) {
    return {
      x: x + Math.sin((30 + x + (time / 10)) / 100) * 4,
      y: y + Math.sin((15 + x + (time / 10)) / 100) * 5
    };
  },

  function(x, y, time) {
    return {
      x: x + Math.sin((x + (time / 10)) / 100) * 2,
      y: y + Math.sin((10 + x + (time / 10)) / 100) * 3
    }
  }
];

let shapes = [];
canvas.width = window.innerWidth;
canvas.height = window.innerHeight;

class Shape {
  constructor(x, y) {
    this.x = x;
    this.y = y;
    this.size = getRand(0.1, 0.6);
    this.outline = 5 * this.size;
    this.motion = changeOfCoordinatesWithTime[randomInt(0, changeOfCoordinatesWithTime.length - 1)];
  }
}

class Cross extends Shape {
  constructor(x, y) {
    super(x, y);
    this.angle = getRand(0, 360);
    this.side = 20 * this.size;
    this.rotationSpeed = getRand(-0.2, 0.2);
  }
}

class Circle extends Shape {
  constructor(x, y) {
    super(x, y);
    this.radius = 12 * this.size;
  }
}

function createForms(sumFrom, sumTo) {
  for (let i = 0; i < randomInt(sumFrom, sumTo); i++) {
    shapes.push(
      new Cross(randomInt(0, canvas.width), randomInt(0, canvas.height))
    );
  }

  for (let i = 0; i < randomInt(sumFrom, sumTo); i++) {
    shapes.push(
      new Circle(randomInt(0, canvas.width), randomInt(0, canvas.height))
    );
  }
}

function drawingCircle(circle) {
  ctx.strokeStyle = 'green';
  let { x, y } = circle.motion(circle.x, circle.y, Date.now());
  ctx.lineWidth = circle.outline;
  ctx.beginPath();
  ctx.arc(x, y, circle.radius, 0, 2 * Math.PI, false);
  ctx.stroke();
}

function drawingCross(cross) {
  let rad = cross.angle * Math.PI / 180;
  let { x, y } = cross.motion(cross.x, cross.y, Date.now());
  let halfSide = cross.side / 2;
  ctx.lineWidth = cross.outline;
  ctx.strokeStyle = 'red';
  ctx.translate(x, y);
  ctx.rotate(rad);
  ctx.beginPath();
  ctx.moveTo(0 - halfSide, 0);
  ctx.lineTo(0 + halfSide, 0);
  ctx.stroke();
  ctx.beginPath();
  ctx.moveTo(0, 0 - halfSide);
  ctx.lineTo(0, 0 + halfSide);
  ctx.stroke();
  ctx.rotate(-rad);
  ctx.translate(-x, -y);
  cross.angle += cross.rotationSpeed;
}

function getRand(min, max) {
  return Math.random() * (max - min) + min;
}

function randomInt(min, max) {
  return Math.round(getRand(min, max));
}

function tick() {
  ctx.clearRect(0, 0, canvas.width, canvas.height);
  shapes.forEach(Shape => {
    if (Shape instanceof Cross) {
      drawingCross(Shape);
    } else {
        drawingCircle(Shape);
      }
  });
}

createForms(90, 140);
setInterval(tick, 1000 / 10);