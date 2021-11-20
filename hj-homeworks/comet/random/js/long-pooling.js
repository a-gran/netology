const longPoolUnit = document.querySelector('.long-pooling');
const longPoolCell = longPoolUnit.querySelectorAll('div');
poolingLongPoll();

function poolingLongPoll() {
  const xhr = new XMLHttpRequest();
  xhr.addEventListener('load', event => {
    if (200 <= event.target.status && event.target.status < 300) {
      const responseNumber = +event.target.responseText;
      selectCell(longPoolCell, responseNumber);
    }
    poolingLongPoll();
  });
  xhr.open('GET', 'https://neto-api.herokuapp.com/comet/long-pooling');
  xhr.send();
}