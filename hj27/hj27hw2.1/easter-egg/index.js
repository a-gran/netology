let secret = document.getElementsByClassName('secret')[0];
let nav = document.getElementsByTagName('nav')[0];
let easterEggArray = [];
let secretWord = "KeyY,KeyT,KeyN,KeyJ,KeyK,KeyJ,KeyU,KeyB,KeyZ";

slidingSidebar = () => {
  if(event.ctrlKey && event.altKey && event.code === 'KeyT') {
    nav.classList.toggle('visible'); // исправил на toggle
  }
}

easterEgg = () => {
  easterEggArray.push(event.code);
  if (easterEggArray.join().search(secretWord) != -1) {
    secret.classList.add('visible');
    return easterEggArray = [];
  } else {
      secret.classList.remove('visible');
    }
}

function allEvent(event) {
    easterEgg();
    slidingSidebar();
}

document.addEventListener('keydown', allEvent);