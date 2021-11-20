let imgs = [
  'headquarters.jpg',
  'breuer-building.jpg',
  'guggenheim-museum.jpg',
  'new-museum.jpg',
  'IAC.jpg'
]

prevPhoto = () => {
  step -= 1;
  if(step < 0) {
    step = imgs.length - 1;
  }
  slider.src = `i/${imgs[step]}`;
}

nextPhoto = () => {
  step +=1;
  if (step === imgs.length ){
    step = 0;
  }
  slider.src = `i/${imgs[step]}`;
}

let step = -1;
let slider = document.getElementById('currentPhoto');
let btnPrev = document. getElementById('prevPhoto');
let btnNext = document.getElementById('nextPhoto');

prevPhoto();
btnPrev.onclick = prevPhoto;
btnNext.onclick = nextPhoto;