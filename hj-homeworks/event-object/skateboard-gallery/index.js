let view = document.getElementById('view');
let nav = document.getElementById('nav');
let gallery = nav.getElementsByTagName('a');

for (let img of gallery) {
  img.addEventListener('click', setImg);
}

function setImg(ev) {
  ev.preventDefault();
  for (let img of gallery) {
    img.classList.remove('gallery-current');
  }
  ev.currentTarget.classList.add('gallery-current');
  view.src = ev.currentTarget.href;
}

