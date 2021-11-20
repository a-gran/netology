let moveElem = null;
const trashBin = document.querySelector('#trash_bin');
let changeX = 0;
let changeY = 0;

document.addEventListener('mousedown', ev => {
  if(ev.which != 1) { return }
  if(ev.target.classList.contains('logo')) {
    moveElem = ev.target;
    const borders = ev.target.getBoundingClientRect();
    changeX =  borders.width/2 - window.pageXOffset;
    changeY =  borders.height/2 - window.pageYOffset;
  }
})

document.addEventListener('mousemove', ev => {
  if(moveElem) {
    ev.preventDefault();
    moveElem.style.left = ev.pageX - changeX  + 'px';
    moveElem.style.top = ev.pageY  - changeY + 'px';
    moveElem.classList.add('moving')
  }
})

document.addEventListener('mouseup', ev => {
  if(moveElem) {
    const control = document.elementFromPoint(ev.clientX, ev.clientY)

    if(control) {
      control.appendChild(moveElem);
      moveElem.classList.remove('moving');
      moveElem = null;
    }
  }
})