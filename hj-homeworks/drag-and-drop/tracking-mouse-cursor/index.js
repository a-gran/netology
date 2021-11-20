const catsEyes = document.getElementsByClassName('cat_eye');
document.addEventListener('mousemove', ev => {
  let eyeCavity;
  Array.from(catsEyes).forEach( eye => {
    if(eye.classList.contains('cat_eye_left')) {
      eyeCavity  = document.querySelector('.cat_position_for_left_eye');
    } else {
      eyeCavity = document.querySelector('.cat_position_for_right_eye');
    }
    let eyeCavityConnect = eyeCavity.getBoundingClientRect();
    if(ev.pageY < eyeCavityConnect.top) {
      eye.style.top = 0 + 'px';
    } else if(ev.pageY > eyeCavityConnect.bottom) {
      eye.style.top = 50 + '%';
    } else {
      eye.style.top = 25 + '%';
    }
    if(ev.pageX > eyeCavityConnect.right) {
      eye.style.left = 50 + '%';
    } else if(ev.pageX < eyeCavityConnect.left) {
      eye.style.left = 0 + 'px';
    } else {
      eye.style.left = 25 + '%';
    }
  })
})