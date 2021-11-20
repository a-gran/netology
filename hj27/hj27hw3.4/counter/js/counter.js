let outcomeCount = document.querySelector('.counter');
let outcomeErr = document.querySelector('.errors');
let connection = new WebSocket('wss://neto-api.herokuapp.com/counter');

connection.addEventListener('message', event => {
  let message = JSON.parse(event.data);
  outcomeCount.innerText = `${message.connections}`;
  outcomeErr.value = `${message.errors}`;
});

window.addEventListener('beforeunload', () => {
  connection.close(1000)
})