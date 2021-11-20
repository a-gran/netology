let selectId = document.getElementById('acSelect');
let btnSeatMap = document.getElementById('btnSeatMap');
let btnSetEmpty = document.getElementById('btnSetEmpty');
let btnSetFull = document.getElementById('btnSetFull');
let seatMapDiv = document.getElementById('seatMapDiv');
let seatMapTitle = document.getElementById('seatMapTitle');
let totalHalf = document.getElementById('totalHalf');
let totalPax = document.getElementById('totalPax');
let totalAdult = document.getElementById('totalAdult');

btnSetEmpty.disabled = true;
btnSetFull.disabled = true;

function btnShowMap(data) {
  btnSeatMap.addEventListener('click', (elem) => {
    elem.preventDefault();
    totalPax.textContent = totalAdult.textContent = totalHalf.textContent = 0;
    createMap(data);
  });
}

function dataUpload(value) {
  fetch(`https://neto-api.herokuapp.com/plane/${value}`)
    .then(response => {
      if (200 <= response.status && response.status < 300) {
        return response;
      } throw new Error(response.statusText);
    })
    .then(res => res.json()).then(data => {
      seatMapTitle.textContent = `${data.title} (${data.passengers} пассажиров)`;
      btnShowMap(data);
    });
}

function createMap(data) {
  btnSetFull.disabled = false;
  btnSetEmpty.disabled = false;

  while (seatMapDiv.firstChild) {
    seatMapDiv.removeChild(seatMapDiv.firstChild);
  }

  data.scheme.forEach((item, i) => {
    let letters = item === 4 ? [].concat('', data.letters4, '') : ((item === 6) ? data.letters6 : []);
    let row = newElem('div', {class: 'row seating-row text-center'}, [
      newElem('div', {class: 'col-xs-1 row-number'}, [
        newElem('h2', null, `${i + 1}`)
      ])
    ]);
    let colLeft = newElem('div', {class: 'col-xs-5'});
    let colRight = newElem('div', {class: 'col-xs-5'});

    letters.forEach((letter, i) => {
      if (i <= 2) {
        colLeft.appendChild(createSeat(letter));
      } else {
        colRight.appendChild(createSeat(letter));
      }
    });

    row.appendChild(colLeft);
    row.appendChild(colRight);
    seatMapDiv.appendChild(row);
  });
}

function createSeat(value) {
  if (value !== '') {
    let seat = newElem('div', {class: 'col-xs-4 seat'}, [
      newElem('span', {class: 'seat-label'}, value)
    ]);
    seat.addEventListener('click', choosePlace);
    return seat;
  } else {
    return newElem('div', {class: 'col-xs-4 no-seat'});
  }
}

function checkPlace(type) {
  let seatList = seatMapDiv.querySelectorAll('.seat');
  Array.from(seatList).forEach(item => {
    if (!item.classList.contains('adult') && type === 'add') {
      item.classList.add('adult');
    } else if ((item.classList.contains('adult') || item.classList.contains('half')) && type === 'remove') {
      item.classList.remove('adult', 'half');
    }
  });
  cntOfSeat();
}

function cntOfSeat() {
  let seats = seatMapDiv.querySelectorAll('.seat');
  Array.from(seats).forEach(item => {
    if (item.classList.contains('adult') || item.classList.contains('half')) {
      totalPax.textContent = (parseInt(totalPax.textContent) < seats.length) ? parseInt(totalPax.textContent) + 1 : seats.length;
    } else {
      totalPax.textContent = (parseInt(totalPax.textContent) > 0) ? parseInt(totalPax.textContent) - 1 : 0;
    }
    if (item.classList.contains('adult')) {
      totalAdult.textContent = (parseInt(totalAdult.textContent) < seats.length) ? parseInt(totalAdult.textContent) + 1 : seats.length;
    } else {
      totalAdult.textContent = (parseInt(totalAdult.textContent) > 0) ? parseInt(totalAdult.textContent) - 1 : 0;
    }
    if (item.classList.contains('half')) {
      totalHalf.textContent = (parseInt(totalHalf.textContent) < seats.length) ? parseInt(totalHalf.textContent) + 1 : seats.length;
    } else {
      totalHalf.textContent = (parseInt(totalHalf.textContent) > 0) ? parseInt(totalHalf.textContent) - 1 : 0;
    }
  });
}

function choosePlace(event) {
  let target = event.currentTarget;
  if (!target.classList.contains('adult')) {
    target.classList.add('adult');
    totalPax.textContent = parseInt(totalPax.textContent) + 1;
    totalAdult.textContent = parseInt(totalAdult.textContent) + 1;
  } else {
    target.classList.remove('adult');
    totalPax.textContent = parseInt(totalPax.textContent) - 1;
    totalAdult.textContent = parseInt(totalAdult.textContent) - 1;
  }
  if (!target.classList.contains('half') && event.altKey) {
    target.classList.add('half');
    totalPax.textContent = parseInt(totalPax.textContent) + 1;
    totalHalf.textContent = parseInt(totalHalf.textContent) + 1;
  } else if (target.classList.contains('half') && event.altKey) {
    target.classList.remove('half');
    totalPax.textContent = parseInt(totalPax.textContent) - 1;
    totalHalf.textContent = parseInt(totalHalf.textContent) - 1;
  }
}

function newElem(tagName, attrs, childs) {
  let el = document.createElement(tagName);
  if (typeof attrs === 'object' && attrs !== null) {
    Object.keys(attrs).forEach(attr => el.setAttribute(attr, attrs[attr]));
  }
  if (typeof childs === 'string') {
    el.textContent = childs;
  } else if (childs instanceof Array) {
    childs.forEach(child => el.appendChild(child));
  }
  return el;
}

document.addEventListener('DOMContetLoaded', dataUpload(selectId.value));
selectId.addEventListener('change', event => dataUpload(event.target.value));
btnSetFull.addEventListener('click', (elem) => {
  elem.preventDefault();
  checkPlace('add');
});
btnSetEmpty.addEventListener('click', (elem) => {
  elem.preventDefault();
  checkPlace('remove');
});