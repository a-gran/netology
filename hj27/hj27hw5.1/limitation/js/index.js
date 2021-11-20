let textarea = document.querySelector('.textarea');
textarea.addEventListener('focus', () => {
  document.querySelector('.block').classList.add('active');
})

textarea.addEventListener('blur', () => {
  document.querySelector('.block').classList.remove('active');
})

textarea.addEventListener('keydown', expectation(() => {
  document.querySelector('.block').classList.add('active');
  document.querySelector('.message').classList.remove('view');
}))

textarea.addEventListener('keydown', ftimeout(() => {
  document.querySelector('.block').classList.remove('active');
  document.querySelector('.message').classList.add('view');
}, 2000))

function expectation(callback, interval){
  let isWaiting = false;
  return function() {
    callback.apply();
    isWaiting = true;
    setTimeout(() => {
      isWaiting = false;
    }, interval);
  }
}

function ftimeout(callback, interval) {
  let timeout;
  return () => {
    timeout = +'';
    timeout = setTimeout(function() {
      timeout = null;
      callback();
    }, interval);
  };
}