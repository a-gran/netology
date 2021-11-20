let request = new XMLHttpRequest();
request.addEventListener('load', showPreloader);
request.open('GET', 'components/e-mail.html');
request.send();
let preview = document.querySelector('#preloader');
let tabs = document.querySelectorAll('nav a');
let cont = document.querySelector('#content');
Array.from(tabs).forEach(tab => { tab.addEventListener('click', defaultEvent); });

function defaultEvent(event) {
  for (let tab of tabs) {
    tab.classList.remove('active');
  }
  this.classList.add('active');
  event.priventDefault();
  request.addEventListener('load', showPreloader);
  request.addEventListener('onload', hiddenCont);
  request.open('GET', this.href);
  request.send();
}

showPreloader = () => {
  preview.classList.remove('hidden');
}
onloadCont = () => {
  cont.innerHTML = request.responseText;
}
hiddenCont = () => {
  preview.classList.add('hidden');
}