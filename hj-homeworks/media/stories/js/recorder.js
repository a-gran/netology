if (navigator.mediaDevices === undefined) {
  navigator.mediaDevices = {};
}

if (navigator.mediaDevices.getUserMedia === undefined) {
  navigator.mediaDevices.getUserMedia = function (constraints) {
    var getUserMedia = navigator.getUserMedia ||
      navigator.webkitGetUserMedia ||
      navigator.mozGetUserMedia ||
      navigator.msGetUserMedia;
      if (!getUserMedia) {
        return Promise.reject(new Error('getUserMedia is not implemented in this browser'));
      }
      return new Promise((resolve, reject) => {
        getUserMedia.call(navigator, constraints, resolve, reject);
    });
  }
}

function createThumbnail(video) {
  return new Promise((done, fail) => {
    const preview = document.createElement('video');
    preview.src = URL.createObjectURL(video);
    preview.addEventListener('loadeddata', () => preview.currentTime = 2);
    preview.addEventListener('seeked', () => {
      const snapshot = document.createElement('canvas');
      const context = snapshot.getContext('2d');
      snapshot.width = preview.videoWidth;
      snapshot.height = preview.videoHeight;
      context.drawImage(preview, 0, 0);
      snapshot.toBlob(done);
    });
  });
}

function record(app) {
  app.mode = 'preparing';
  return new Promise((done, fail) => {
    const resolvedData = {};
    navigator.mediaDevices
      .getUserMedia(app.config)
      .then((stream) => {
        let recorder = new MediaRecorder(stream);
        const video = document.createElement('video');
        video.src = URL.createObjectURL(stream);
        app.preview.srcObject = stream;
        app.mode = 'recording';
        let bits = [];
        recorder.addEventListener('dataavailable', (e) => bits.push(e.data));
        recorder.addEventListener('stop', (e) => {
          const recorded = new Blob(bits, { 'type' : recorder.mimeType });
          bits = null;
          recorder = stream = app.preview.srcObject = null;
          createThumbnail(recorded)
            .then(thumbnailBlob => {
              resolvedData.video = recorded;
              resolvedData.frame = thumbnailBlob;
              app.mode = 'sending';
              done(resolvedData);
            })
            .catch(err => {
              throw new Error(err.message);
            });
        });
        recorder.start(1000);
        setTimeout(function () {
          recorder.stop();
          stream.getVideoTracks().forEach(track => track.stop());
        }, app.limit);
      })
      .catch(err => console.error('Произошла ошибка: ', err.message));
  });
}