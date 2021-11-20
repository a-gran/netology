'use strict';

let canvas = document.querySelector('canvas');
let ctx = canvas.getContext('2d');
let graph = [];
let changeHue = true;
let draw = false;
let necessaryRepaint = false;
let lineThickness = true;
let brushThickness = 100;
let colors = getRand(0, 359);
document.body.style.overflow = 'hidden';
window.addEventListener('resize', changeCanvasSize);
window.addEventListener('load', changeCanvasSize);
canvas.addEventListener("mouseleave", stopdraw);
canvas.addEventListener('dblclick', clearCanvas);
canvas.addEventListener("mousedown", startNewCurve);
canvas.addEventListener("mouseup", stopdraw);
canvas.addEventListener("mousemove", drawCurve);

class CurvePoint {
  constructor(x, y, hue, brushThickness){
    this.x = x;
    this.y = y;
    this.hue = hue;
    this.brushThickness = brushThickness;
  }
}

function changeCanvasSize() {
  canvas.height = window.innerHeight;
  canvas.width = window.innerWidth;
  clearCanvas();
}

function clearCanvas() {
  necessaryRepaint = true;
  graph = [];
}

function drawCurve(event) {
  if (draw) {
    let point = new CurvePoint(event.offsetX, event.offsetY, colors, brushThickness);
    necessaryRepaint = true;
    graph[graph.length - 1].push(point);
  }
}

function startNewCurve(event) {
  let curve = [];
  draw = true;
  necessaryRepaint = true;
  changeHue = !event.shiftKey;
  curve.push(new CurvePoint(event.offsetX, event.offsetY, colors, brushThickness));
  graph.push(curve);
}

function circle(point) {
  let pointCoords = [point.x, point.y];
  ctx.beginPath();
  ctx.fillStyle = `hsl(${point.hue}, 100%, 50%)`;
  ctx.arc(...pointCoords, point.brushThickness / 2, 0, 2 * Math.PI);
  ctx.fill();
}

function repaint () {
  ctx.clearRect(0, 0, canvas.width, canvas.height);
  graph.forEach((curve) => {
    circle(curve[0]);
    smoothCurve(curve);
  });
}

function smoothCurve(points) {
  for(let i = 0; i < points.length - 1; i++) {
    let pointTo = points[i + 1];
    let pointFrom = points[i];
    ctx.beginPath();
    ctx.lineCap = 'round';
    ctx.lineJoin = 'round';
    ctx.lineWidth = pointFrom.brushThickness;
    ctx.strokeStyle = `hsl(${pointFrom.hue}, 100%, 50%)`;
    ctx.lineTo(pointFrom.x, pointFrom.y);
    ctx.stroke();
    ctx.lineWidth = pointTo.brushThickness;
    ctx.strokeStyle = `hsl(${pointTo.hue}, 100%, 50%)`;
    ctx.lineTo(pointTo.x, pointTo.y);
    ctx.stroke();
    ctx.closePath();
  }
}

function tick () {
  if(necessaryRepaint) {
    repaint();
    necessaryRepaint = false;
    lineThickness ? brushThickness++ : brushThickness--;
    changeHue ? colors++ : colors--;
    if (colors > 359) {
      colors = 0;
    } else if (colors < 0) {
      colors = 359;
    }
    if (brushThickness >= 100) {
      lineThickness = false;
    } else if (brushThickness <= 5) {
      lineThickness = true;
    }
  }
  window.requestAnimationFrame(tick);
}

function getRand(min, max) {
  return Math.round(Math.random() * (max - min) + min);
}

function stopdraw() {
  draw = false;
}

tick();