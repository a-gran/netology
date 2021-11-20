'use strict';
let content = document.querySelector('.content');

function dataOnload(callbackName, url) {
  return new Promise((done, fail) => {
    let script = document.createElement('script');
    script.src = `${url}?callback=${callbackName}`;
    document.body.appendChild(script);
    window.callbackName = done;
  });
}

function createBadges(data) {
  let dataTechnology = document.querySelector('[data-technologies]');
  for (let key in data) {
    let icons = document.createElement('span');
    icons.classList.add('devicons', `devicons-${data[key]}`);
    dataTechnology.appendChild(icons);
  }
}

function initProfile(data) {
  for (let key in data) {
    switch(key) {
      case 'id':
        dataOnload('createBadges', `https://neto-api.herokuapp.com/profile/${data[key]}/technologies`)
          .then(content.removeAttribute('style'));
        break;
      case 'pic':
        document.querySelector(`[data-${key}]`).src = changeUrl(data[key]);
        break;
      default:
        document.querySelector(`[data-${key}]`).textContent = data[key];
    }
  }
}

function changeUrl(url) {
  return url.replace(/:\d+?\//ig, '/');
}

dataOnload('initProfile', 'https://neto-api.herokuapp.com/profile/me');