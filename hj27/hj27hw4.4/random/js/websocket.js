let wsocketUnit = document.querySelector('.websocket');
let wsocketUnitCell = wsocketUnit.querySelectorAll('div');
let connection = new WebSocket('wss://neto-api.herokuapp.com/comet/websocket');
connection.addEventListener('message', event => {
  selectCell(wsocketUnitCell, event.data);
});
window.addEventListener('beforeunload', () => {
  connection.close(1000, 'Work is done');
})