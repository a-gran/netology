let piano = document.getElementsByClassName('set')[0];
let pianoSounds = piano.querySelectorAll('audio');
let pianoKeys = document.getElementsByTagName('li');

let higher = [
  'sounds/higher/first.mp3',
  'sounds/higher/second.mp3',
  'sounds/higher/third.mp3',
  'sounds/higher/fourth.mp3',
  'sounds/higher/fifth.mp3'
];

let middle = [
  'sounds/middle/first.mp3',
  'sounds/middle/second.mp3',
  'sounds/middle/third.mp3',
  'sounds/middle/fourth.mp3',
  'sounds/middle/fifth.mp3'
];

let lower = [
  'sounds/lower/first.mp3',
  'sounds/lower/second.mp3',
  'sounds/lower/third.mp3',
  'sounds/lower/fourth.mp3',
  'sounds/lower/fifth.mp3'
];

function setHigher(press) {
  if(press.altKey === false) { return };
  piano.className = piano.className.replace('middle', 'higher');
}

function removeHigher(press) {
  piano.classList.remove('higher');
  piano.classList.add('middle');
}

function setLower(press) {
  if(press.shiftKey === false) { return };
  piano.className = piano.className.replace('middle', 'lower');
}

function removeLower(press) {
  piano.classList.remove('lower');
  piano.classList.add('middle');
}

for(let key of pianoKeys) {
  key.addEventListener('click', () => {
    for(let sound of pianoSounds) {
      sound.pause();
    }
    if(piano.classList.contains('higher')) {
      pianoSounds.forEach((sound, item) => {
      sound.src = higher[item];
    });
    } else if(piano.classList.contains('lower')) {
        pianoSounds.forEach((sound, item) => {
        sound.src = lower[item];
    });
    } else {
        pianoSounds.forEach((sound, item) => {
        sound.src = middle[item];
      });
    }
    key.querySelector('audio').play();
  })
}

document.addEventListener('keydown', setLower);
document.addEventListener('keydown', setHigher);
document.addEventListener('keyup', removeLower);
document.addEventListener('keyup', removeHigher);