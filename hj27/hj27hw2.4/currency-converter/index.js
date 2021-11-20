const idContent = document.querySelector('#content');
const idFrom = document.querySelector('#from');
const idLoader = document.querySelector('#loader');
const idSource = document.querySelector('#source');
const idTo = document.querySelector('#to');
const idResult = document.querySelector('#result');

const xhr = new XMLHttpRequest();
xhr.open("GET", "https://neto-api.herokuapp.com/currency");
xhr.send();
xhr.addEventListener('load', onLoad);
xhr.addEventListener('loadstart', startLoad);
xhr.addEventListener('loadend', endLoad);

idSource.addEventListener('input', showReport);
idFrom.addEventListener('input', showReport);
idTo.addEventListener('input', showReport);

function onLoad() {
  if (xhr.status !== 200) {
    console.log(`Ответ ${xhr.status}: ${xhr.statusText}`);
  } else {
    const data = JSON.parse(xhr.responseText);
    let str ='';
    data.forEach((item) => {
      str += `<option value="${item.value}">${item.code}</option>`;
    })
    idFrom.innerHTML = str;
    idTo.innerHTML = str;
    showReport();
  }
}

function showReport() {
  idResult.value = (Math.round(idSource.value * idFrom.value / idTo.value * 100) / 100).toFixed(2);
  console.log(`from = ${idFrom.value}  to=${idTo.value}`)
}

function startLoad() {
  idLoader.classList.remove('hidden');
  idContent.classList.add('hidden');
}

function endLoad() {
  idLoader.classList.add('hidden');
  idContent.classList.remove('hidden');
}