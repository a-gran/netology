let pollUnit = document.querySelector('.pooling');
let pollCell = pollUnit.querySelectorAll('div');
poolingPoll();
setInterval(poolingPoll, 1000 * 7);

function poolingPoll() {
  let xhr = new XMLHttpRequest();
  xhr.addEventListener('load', event => {
    if (event.target.status == 200) {
      let responseNumber = +event.target.responseText;
      selectCell(pollCell, responseNumber);
    }
  });
  xhr.open('GET', 'https://neto-api.herokuapp.com/comet/pooling');
  xhr.send();
}

function selectCell(blocksArray, position) {
  cleanSelect(blocksArray);
  blocksArray[position - 1].classList.add('flip-it');
}

function cleanSelect(blocksArray) {
  blocksArray.forEach(el => el.classList.remove('flip-it'))
}
