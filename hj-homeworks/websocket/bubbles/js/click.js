'use strinct';

let body = document.querySelector('body')
let connection = new WebSocket('wss://neto-api.herokuapp.com/mouse');
connection.addEventListener('open', () => {
  showBubbles(connection);
});
body.addEventListener('click', pos => {
  connection.send(JSON.stringify({ 
    x: pos.x,
    y: pos.y
  }));
})
