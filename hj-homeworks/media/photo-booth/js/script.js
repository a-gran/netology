const appPhoto = document.querySelector('.app');
const controlsPhoto = document.querySelector('.controls');
const takePhoto = document.getElementById('take-photo');
const errorMessage = document.getElementById('error-message');
const listPhoto = document.querySelector('.list');
const appUrlPhoto = 'https://neto-api.herokuapp.com/photo-booth';

const request = {
  method: 'POST',
  'Content-Type': 'multipart/form-data'
};

let soundPhoto;
let checkErr = false;

// Доступ к API
(function () { sendImage('') }) ();

(function () {
  navigator.mediaDevices
    .getUserMedia({video: true, audio: false})
    .then(stream => {
      const video = document.createElement('video');
      video.src = URL.createObjectURL(stream);
      video.id = 'video-stream';
      if (!checkErr) {
        appPhoto.appendChild(video);
        controlsPhoto.classList.add('visible');
      }
    })
    .catch(error => {
      checkErr = true;
      errorMessage.textContent = 'Нет доступа к камере';
      errorMessage.classList.add('visible');
      console.error(error);
    });
}) ();

(function () {
  soundPhoto = document.createElement('audio');
  soundPhoto.src = './audio/click.mp3';
  document.body.appendChild(soundPhoto);
}) ();

takePhoto.addEventListener('click', event => {
  try {
    const video = document.getElementById('video-stream');
    if (!video) {
      throw new Error('Видео не найдено!');
    }

    const canvas = document.createElement('canvas');
    const canvasCont = canvas.getContext('2d');
    canvas.width = video.videoWidth;
    canvas.height = video.videoHeight;
    canvasCont.drawImage(video, 0, 0);

    const imageUrl = canvas.toDataURL();
    const imageHtml = captureImage(imageUrl);

    if (!listPhoto.childNodes.length) {
      listPhoto.appendChild(imageHtml);
    } else {
      listPhoto.insertBefore(imageHtml, listPhoto.childNodes[0]);
    }
    soundPhoto.play();

  } catch (e) {
    console.log('Произошла ошибка: ', e.message);
  }
});

function captureImage(imgPath) {
  const figure = document.createElement('figure');
  const img = document.createElement('img');
  const figcaption = document.createElement('figcaption');
  const anchor = document.createElement('a');
  const icon = document.createElement('i');
  icon.classList.add('material-icons');
  const anchorDownload = anchor.cloneNode();
  const anchorUpload = anchor.cloneNode();
  const anchorDelete = anchor.cloneNode();
  const iconDownload = icon.cloneNode();
  const iconUpload = icon.cloneNode();
  const iconDelete = icon.cloneNode();
  img.src = imgPath;
  iconDownload.textContent = 'file_download';
  anchorDownload.href = imgPath;
  anchorDownload.download = 'snapshot.png';
  anchorDownload.appendChild(iconDownload);
  iconUpload.textContent = 'file_upload';
  anchorUpload.appendChild(iconUpload);
  iconDelete.textContent = 'delete';
  anchorDelete.appendChild(iconDelete);

  [anchorDownload, anchorUpload, anchorDelete].forEach(node => {
    figcaption.appendChild(node);
  });
  figure.appendChild(img);
  figure.appendChild(figcaption);

  anchorDownload.addEventListener('click', event => {
    event.currentTarget.style.display = 'none';
  });

  anchorUpload.addEventListener('click', event => {
    const clickButton = event.currentTarget;
    const response = sendImage(imgPath);

    response
      .then(apiResponse => clickButton.style.display = 'none')
      .catch(console.error);
  });

  anchorDelete.addEventListener('click', event => {
    figure.remove();
  });
  return figure;
}

function sendImage(imageSrc) {
  return fetch(imageSrc)
    .then(response => response.blob())
    .then(imageBlob => {
      const sendPhoto = Object.assign({}, request);
      const requestData = new FormData();
      requestData.append('image', imageBlob);
      sendPhoto.body = requestData;
      return fetch(appUrlPhoto, sendPhoto);
    })
    .then(apiResponse => {
      if (apiResponse.status < 200 || apiResponse.status >= 300) {
        throw new Error('API availability issues');
      }
      return new Promise((done, fail) => {
        try {
          done(apiResponse);
        } catch (e) {
          fail(e);
        }
      });
    })
    .catch(error => {
      checkErr = true;
      errorMessage.textContent = 'Проблема с доступностью API';
      errorMessage.classList.add('visible');
      console.error(error);
      return false;
    });
}