let imgs = ['../i/airmax-jump.png', '../i/airmax-on-foot.png', '../i/airmax-playground.png', '../i/airmax-top-view.png', '../i/airmax.png'];
let index = 0;

setInterval(function() {
  if(index == imgs.length) {
    index = 0;
  }
  document.getElementById('slider').src = imgs[index++];
}, 5000);