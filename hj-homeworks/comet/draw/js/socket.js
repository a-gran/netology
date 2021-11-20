'use strict';

let connection = new WebSocket('wss://neto-api.herokuapp.com/draw');
connection.addEventListener('open', event => {
  editor.addEventListener('update', sendCanvas);
});
connection.addEventListener('close', event => {
  editor.removeEventListener('update', sendCanvas);
});
function sendCanvas(event) {
  event.canvas.toBlob(blob => connection.send(blob));
}