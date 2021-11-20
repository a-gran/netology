const eye = document.querySelector('.big-book__eye');
const pupil = document.querySelector('.big-book__pupil');

window.addEventListener('mousemove', event => {
  const sizeBody = document.body.getBoundingClientRect();
  const browserWindow = {
    height: document.documentElement.clientHeight,
    width: window.innerWidth
  };
  const sizeEye = eye.getBoundingClientRect();
  const eyeSize = {
    width: sizeEye.width,
    height: sizeEye.height
  };
  const centerEye = {
    y: (eyeSize.height / 2) + (sizeEye.top - sizeBody.top),
    x: (eyeSize.width / 2) + (sizeEye.left - sizeBody.left)
  };
  const mousePosition = {
    x: event.pageX,
    y: event.pageY
  };

  const pupilPosY = function() {
    const distinctionY = mousePosition.y - centerEye.y;
    const posY = (function () {
      if (distinctionY < 0) {
        const eyeOffsetFromTop = (sizeEye.top + (eyeSize.height / 2));
        return ((distinctionY / eyeOffsetFromTop) * 100);
      } else if (distinctionY > 0) {
        const eyeOffsetFromBottom = browserWindow.height - (sizeEye.bottom - (eyeSize.height / 2));
        return ((distinctionY / eyeOffsetFromBottom) * 100);
      }
      return 0;
    }) ();
    return posY;
  };

  const pupilPosX = function() {
    const rangeX = {
      from: -centerEye.x,
      to: browserWindow.width - centerEye.x
    };
    const distinctionX = mousePosition.x - centerEye.x;
    const posX = (function () {
      if (distinctionX < 0) {
        return (-(distinctionX / rangeX.from) * 100);
      } else if (distinctionX > 0) {
        return ((distinctionX / rangeX.to) * 100);
      }
      return 0;
    }) ();
    return posX;
  };

  const posXpupil =  pupilPosX();
  const posYpupil =  pupilPosY();

  const pupilSize = function () {
    const pointX = posXpupil * Math.sign(posXpupil);
    const pointY = posYpupil * Math.sign(posYpupil);
    const sizeCount = ((100 - ((pointX + pointY) / 2)) * 0.03);
    return sizeCount >= 1 ? sizeCount : 1;
  };

  pupil.style.setProperty('--pupil-x', `${posXpupil * 0.3}px`);
  pupil.style.setProperty('--pupil-y', `${posYpupil * 0.3}px`);
  pupil.style.setProperty('--pupil-size', pupilSize());
});
