const urlApi = 'https://neto-api.herokuapp.com';
const errorMoreDrag = 'Чтобы загрузить новое изображение воспользуйтесь кнопкой "Загрузить новое"';
const fileTypeErr = 'Неверный формат файла. Пожалуйста, выберите изображение в формате .png или .jpg.';

let showComments = {};
let host;
let getParseData;
let count = 0;

const canvas = document.createElement('canvas'),
      canvasComments = document.createElement('div'),
      menu = document.querySelector('.menu'),
      menuBurger = menu.querySelector('.burger'),
      menuСomments = menu.querySelector('.comments'),
      menuNewImg = menu.querySelector('.new'),
      menuUrl = menu.querySelector('.menu__url'),
      menuDraw = menu.querySelector('.draw'),
      error = document.querySelector('.error'),
      loader = document.querySelector('.image-loader'),
      currentImage = document.querySelector('.current-image'),
      commentForm = document.querySelector('.comments__form'),
      app = document.querySelector('.app'),
      menuToggleTitleOn = document.querySelector('.menu__toggle-title_on'),
      menuToggleTitleOff = document.querySelector('.menu__toggle-title_off'),
      commentsOn = document.querySelector('#comments-on'),
      commentsOff = document.querySelector('#comments-off');

function getDate(timestamp) {
  const options = {
    day: '2-digit',
    month: '2-digit',
    year: '2-digit',
    hour: '2-digit',
    minute: '2-digit',
    second: '2-digit'
  };
  const date = new Date(timestamp);
  const dateValue = date.toLocaleString('ru-RU', options);
  return dateValue.slice(0, 8) + dateValue.slice(9);
}

function removeExtension(inputText) {
  let regExp = new RegExp(/\.[^.]+$/gi);
  return inputText.replace(regExp, '');
}

function removeErr() {
  setTimeout(function() {
    hide(error)
  }, 5000);
}

function hide(element) {
  element.setAttribute('style', 'display: none;');
}

//перемещение меню
document.addEventListener('mousemove', throttle(drag));
document.addEventListener('mousedown', dragStartMenu);
document.addEventListener('mouseup', drop);

let menuMovement = null;
let minY, minX, maxX, maxY;
let shiftX = 0;
let shiftY = 0;

function dragStartMenu(event) {
  if(!event.target.classList.contains('drag')) { return; }
  menuMovement = event.target.parentElement;
  minX = app.offsetLeft;
  minY = app.offsetTop;
  maxY = app.offsetTop + app.offsetHeight - menuMovement.offsetHeight;
  maxX = app.offsetLeft + app.offsetWidth - menuMovement.offsetWidth;
  shiftY = event.pageY - event.target.getBoundingClientRect().top - window.pageYOffset;
  shiftX = event.pageX - event.target.getBoundingClientRect().left - window.pageXOffset;
}

function drag(event) {
  if (!menuMovement) { return; }
  let x = event.pageX - shiftX;
  let y = event.pageY - shiftY;
  x = Math.min(x, maxX);
  y = Math.min(y, maxY);
  x = Math.max(x, minX);
  y = Math.max(y, minY);
  menuMovement.style.left = x + 'px';
  menuMovement.style.top = y + 'px';
}

function drop(event) {
  if(menuMovement) { menuMovement = null; }
}

function throttle(callback) {
  let isWaiting = false;
  return function (...rest) {
    if (!isWaiting) {
      callback.apply(this, rest);
      isWaiting = true;
      requestAnimationFrame(() => {
        isWaiting = false;
      });
    }
  };
}

//СОСТОЯНИЕ ПУБЛИКАЦИИ
currentImage.src = '';//очищение фона
menu.dataset.state = 'initial';
app.dataset.state = '';
hide(menuBurger);
app.removeChild(commentForm);
menuNewImg.addEventListener('click', uploadNewFile);
app.addEventListener('drop', onFilesDrop);
app.addEventListener('dragover', event => event.preventDefault());

//загрузка нового изображения
function uploadNewFile(event) {
  hide(error);
  const input = document.createElement('input');
  input.setAttribute('id', 'fileInput');
  input.setAttribute('type', 'file');
  input.setAttribute('accept', 'image/png, image/jpg');
  hide(input);
  menu.appendChild(input);
  document.querySelector('#fileInput').addEventListener('change', event => {
    const files = Array.from(event.currentTarget.files);
    sendFile(files);
  });
  input.click();
  menu.removeChild(input);
}

//перетаскивание картинки для загрузки
function onFilesDrop(event) {
  event.preventDefault();
  hide(error);
  const files = Array.from(event.dataTransfer.files);
  if (count > 0) {
    error.removeAttribute('style');
    error.lastElementChild.textContent = errorMoreDrag;
    removeErr();
    return;
  }
  count++;
  files.forEach(file => {
    if ((file.type === 'image/png') || (file.type === 'image/jpg')) {
      sendFile(files);
    } else {
      error.removeAttribute('style');
      count = 0;
    }
  });
}

//загружаем файл на сервер
function sendFile(files) {
  const formData = new FormData();
  files.forEach(file => {
    const fileTitle = removeExtension(file.name);
    formData.append('title', fileTitle);
    formData.append('image', file);
  });
  loader.removeAttribute('style');
  fetch(`${urlApi}/pic`, {
      body: formData,
      credentials: 'same-origin',
      method: 'POST'
    }).then( res => {
      if (res.status >= 200 && res.status < 300) {
        return res;
      } throw new Error (res.statusText);
    }).then(res => res.json()).then(res => {
      getInformationAboutFile(res.id);
    }).catch(er => {
      console.log(er);
      hide(loader);
    });
}

//очищение форм при загрузке нового изображения
function clearForm() {
  const formComment = app.querySelectorAll('.comments__form');
  Array.from(formComment).forEach(item => {item.remove()})
}

//получаем информацию о файле
function getInformationAboutFile(id) {
  const xhrGetInfo = new XMLHttpRequest();
  xhrGetInfo.open(
    'GET',
    `${urlApi}/pic/${id}`,
    false
  );
  xhrGetInfo.send();
  getParseData = JSON.parse(xhrGetInfo.responseText);
  host = `${window.location.origin}${window.location.pathname}?id=${getParseData.id}`;
  wss();
  setBackground(getParseData);
  menuBurger.style.cssText = ``;
  showMenu();
  currentImage.addEventListener('load', () => {
    hide(loader);
    createBlockCnvsCom();
    createCanvas();
  });
  updateCommentForm(getParseData.comments);
}

//СОСТОЯНИЕ РЕЦЕНЗИРОВАНИЯ
menuBurger.addEventListener('click', showMenu);
//показать меню рецензирования
function showMenu() {
  menu.dataset.state = 'default';
  Array.from(menu.querySelectorAll('.mode')).forEach(modeItem => {
    modeItem.dataset.state = '';
    modeItem.addEventListener('click', () => {
      if (!modeItem.classList.contains('new')) {
        menu.dataset.state = 'selected';
        modeItem.dataset.state = 'selected';
      }
      if (modeItem.classList.contains('share')) {
        menuUrl.value = host;
      }
    })
  })
}

function showComMenu() {
  menu.dataset.state = 'default';
  Array.from(menu.querySelectorAll('.mode')).forEach(modeItem => {
    if (!modeItem.classList.contains('comments')){ return; }
    menu.dataset.state = 'selected';
    modeItem.dataset.state = 'selected';
  })
}

//устанавливаем фон
function setBackground(fileInfo) {
  currentImage.src = fileInfo.url;
}

//КОММЕНТАРИИ
canvas.addEventListener('click', checkComment);
menuToggleTitleOn.addEventListener('click', markCheckOn);
menuToggleTitleOff.addEventListener('click', markCheckOff);
commentsOn.addEventListener('click', markCheckOn);
commentsOff.addEventListener('click', markCheckOff);

function markCheckOff() {
  const forms = document.querySelectorAll('.comments__form');
  Array.from(forms).forEach(form => {
    form.style.display = 'none';
   })
}

function markCheckOn() {
  const forms = document.querySelectorAll('.comments__form');
  Array.from(forms).forEach(form => {
    form.style.display = '';
  })
}

function checkComment() {
  if (!(menuСomments.dataset.state === 'selected') || !app.querySelector('#comments-on').checked) { return; }
  canvasComments.appendChild(createCommentForm(event.offsetX, event.offsetY));
}

function createCanvas() {
  const width = getComputedStyle(app.querySelector('.current-image')).width.slice(0, -2);
  const height = getComputedStyle(app.querySelector('.current-image')).height.slice(0, -2);
  canvas.width = width;
  canvas.height = height;
  canvas.style.width = '100%';
  canvas.style.height = '100%';
  canvas.style.position = 'absolute';
  canvas.style.top = '0';
  canvas.style.left = '0';
  canvas.style.display = 'block';
  canvas.style.zIndex = '1';
  canvasComments.appendChild(canvas);
}

function createBlockCnvsCom() {
  const width = getComputedStyle(app.querySelector('.current-image')).width;
  const height = getComputedStyle(app.querySelector('.current-image')).height;
  canvasComments.style.cssText = `
    display: block;
    width: ${width};
    height: ${height};
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    position: absolute;
  `;
  app.appendChild(canvasComments);

//вывод комментария
  canvasComments.addEventListener('click', event => {
    if (event.target.closest('form.comments__form')) {
      Array.from(canvasComments.querySelectorAll('form.comments__form')).forEach(form => {
        form.style.zIndex = 2;
      });
      event.target.closest('form.comments__form').style.zIndex = 3;
    }
  });
}

//генерация формы комментариев
function createCommentForm(x, y) {
  const formComment = document.createElement('form');
  formComment.classList.add('comments__form');
  //явно какой-то другой способ нужен вместо innerHTML???
  formComment.innerHTML = `
    <span class="comments__marker"></span><input type="checkbox" class="comments__marker-checkbox">
    <div class="comments__body">
      <div class="comment">
        <div class="loader">
          <span></span>
          <span></span>
          <span></span>
          <span></span>
          <span></span>
        </div>
      </div>
      <textarea class="comments__input" type="text" placeholder="Напишите ответ..."></textarea>
      <input class="comments__close" type="button" value="Закрыть">
      <input class="comments__submit" type="submit" value="Отправить">
    </div>`;

  const left = x - 20;
  const top = y - 12;
  formComment.style.cssText = `top: ${top}px; left: ${left}px; z-index: 2;`;
  formComment.dataset.left = left;
  formComment.dataset.top = top;
  const loaderComment = formComment.querySelector('.loader');
  hide(loaderComment.parentElement);

// отправить
  formComment.addEventListener('submit', msgSend);
  formComment.querySelector('.comments__input').addEventListener('keydown', keySendMessage);

//закрыть
  formComment.querySelector('.comments__close').addEventListener('click', () => {
    formComment.querySelector('.comments__marker-checkbox').checked = false;
  });

//отправка комментария
  function keySendMessage(event) {
    if (event.repeat) { return; }
  }

  function msgSend(event) {
    if (event) {
      event.preventDefault();
    }
    const message = formComment.querySelector('.comments__input').value;
    const msgSend = `message=${encodeURIComponent(message)}&left=${encodeURIComponent(left)}&top=${encodeURIComponent(top)}`;
    comSend(msgSend);
    loaderComment.parentElement.removeAttribute('style');
    formComment.querySelector('.comments__input').value = '';
  }

  function comSend(message) {
    fetch(`${urlApi}/pic/${getParseData.id}/comments`, {
      method: 'POST',
      body: message,
      headers: {
        'Content-Type': 'application/x-www-form-urlencoded'
      },
    }).then( res => {
      if (res.status >= 200 && res.status < 300) { return res; }
      throw new Error (res.statusText);
    }).then(res => res.json()).catch(er => {
      console.log(er)
      formComment.querySelector('.loader').parentElement.style.display = 'none';
    });
  }
  return formComment;
}

//добавление сообщения в форму комментария
function addComMsg(message, form) {
  let divLoader = form.querySelector('.loader').parentElement;
  const newDivMsg = document.createElement('div');
  newDivMsg.classList.add('comment');
  newDivMsg.dataset.timestamp = message.timestamp;
  const blockCreationTime = document.createElement('p');
  blockCreationTime.classList.add('comment__time');
  blockCreationTime.textContent = getDate(message.timestamp);
  newDivMsg.appendChild(blockCreationTime);
  const comMsg = document.createElement('p');
  comMsg.classList.add('comment__message');
  comMsg.textContent = message.message;
  newDivMsg.appendChild(comMsg);
  form.querySelector('.comments__body').insertBefore(newDivMsg, divLoader);
}

//обновление формы комментария
function updateCommentForm(newComment) {
  if (!newComment) { return; }
  Object.keys(newComment).forEach(id => {
    if (id in showComments) { return; }
    showComments[id] = newComment[id];
    let createNewFormAddMsg = true;
    Array.from(app.querySelectorAll('.comments__form')).forEach(form => {
      if (+form.dataset.left === showComments[id].left && +form.dataset.top === showComments[id].top) {
        form.querySelector('.loader').parentElement.style.display = 'none';
        addComMsg(newComment[id], form);
        createNewFormAddMsg = false;
      }
    });

//создаем форму и добавляем в нее сообщение
    if (createNewFormAddMsg) {
      const newForm = createCommentForm(newComment[id].left + 22, newComment[id].top + 14);
      newForm.dataset.left = newComment[id].left;
      newForm.dataset.top = newComment[id].top;
      newForm.style.left = newComment[id].left + 'px';
      newForm.style.top = newComment[id].top + 'px';
      canvasComments.appendChild(newForm);
      addComMsg(newComment[id], newForm);
      if (!app.querySelector('#comments-on').checked) {
        newForm.style.display = 'none';
      }
    }
  });
}

//отображение комментариев, полученных с сервера
function displayComFromServ(wsCom) {
  const wsCommentEdited = {};
  wsCommentEdited[wsCom.id] = {};
  wsCommentEdited[wsCom.id].left = wsCom.left;
  wsCommentEdited[wsCom.id].message = wsCom.message;
  wsCommentEdited[wsCom.id].timestamp = wsCom.timestamp;
  wsCommentEdited[wsCom.id].top = wsCom.top;
  updateCommentForm(wsCommentEdited);
}

//ВЭБ-СОКЕТ-СОЕДИНЕНИЕ
let wssConnection;
function wss() {
  let urlMask;
  wssConnection = new WebSocket(`wss://neto-api.herokuapp.com/pic/${getParseData.id}`);
  wssConnection.addEventListener('message', event => {
    console.log(JSON.parse(event.data));
    if (JSON.parse(event.data).event === 'pic'){
      if (JSON.parse(event.data).pic.mask) {
        canvas.style.background = `url(${JSON.parse(event.data).pic.mask})`;
      }
    }
    if (JSON.parse(event.data).event === 'comment'){
      displayComFromServ(JSON.parse(event.data).comment);
    }
    if (JSON.parse(event.data).event === 'mask'){
      canvas.style.background = `url(${JSON.parse(event.data).url})`;
    }
  });
}

//ГЕНЕРАЦИЯ ССЫЛКИ, ЧТОБЫ ПОДЕЛИТЬСЯ ПОЛУЧИВШИМСЯ ИЗОБРАЖЕНИЕМ
const copyUrl = document.querySelector('.menu_copy');
copyUrl.addEventListener('click', function(event) {
  menuUrl.select();
  //копирование
  try {
    var successCopy = document.execCommand('copy');
    var msg = successCopy ? 'адресс успешно ' : 'адресс не ';
    console.log(`URL ${msg} скопирован в буфер обмена!`);
  } catch(err) {
    console.log('Ошибка копирования!');
  }
  window.getSelection().removeAllRanges();
});

//получаем параметр id из ссылки
let urlAdress = `${window.location.href}`;
let url = new URL(urlAdress);
let elemId = url.searchParams.get('id');
idUrl();

function idUrl() {
  if (!elemId) { return; }
  getInformationAboutFile(elemId);
  showComMenu()
}

//РИСОВАНИЕ
let selectedColor;

Array.from(menu.querySelectorAll('.menu__color')).forEach(color => {
  if (color.checked) {
    selectedColor = getComputedStyle(color.nextElementSibling).backgroundColor;
  }
  color.addEventListener('click', (event) => {
    selectedColor = getComputedStyle(event.currentTarget.nextElementSibling).backgroundColor;
  });
});

const ctx = canvas.getContext('2d');
const BRUSH_RADIUS = 4; //задаем размер кисти для рисования
let curves = [];
let drawing = false;
let newPaint = false;

function circle(point) {
  ctx.beginPath();
  ctx.arc(...point, BRUSH_RADIUS / 2, 0, 2 * Math.PI);
  ctx.fill();
}

function drawСurve (p1, p2) {
  const cp = p1.map((coord, idx) => (coord + p2[idx]) / 2);
  ctx.quadraticCurveTo(...p1, ...cp);
}

//рисуем плавную соединительную линию между точками
function drawSmoothСurve(points) {
  ctx.beginPath();
  ctx.lineWidth = BRUSH_RADIUS;
  ctx.lineJoin = 'round';
  ctx.lineCap = 'round';
  ctx.moveTo(...points[0]);
  for(let i = 1; i < points.length - 1; i++) {
    drawСurve(points[i], points[i + 1]);
  }
  ctx.stroke();
}

function makePoint(x, y) {
  return [x, y];
};

canvas.addEventListener('mousedown', (event) => {
  if (!(menuDraw.dataset.state === 'selected')) { return; }
  drawing = true;
  const curve = [];
  curve.color = selectedColor;
  curve.push(makePoint(event.offsetX, event.offsetY)); 
  curves.push(curve);
  newPaint = true;
});

canvas.addEventListener('mouseup', (event) => {
  drawing = false;
});

canvas.addEventListener('mouseleave', (event) => {
  drawing = false;
});

canvas.addEventListener('mousemove', (event) => {
  if (drawing) {
    const point = makePoint(event.offsetX, event.offsetY)
    curves[curves.length - 1].push(point);
    newPaint = true;
    trottledMaskSend();
  }
});

const trottledMaskSend = throttleCanvas(sendMaskState, 1000);

function repaint () {
  ctx.clearRect(0, 0, canvas.width, canvas.height);
  curves.forEach((curve) => {
    ctx.strokeStyle = curve.color;
    ctx.fillStyle = curve.color;
    circle(curve[0]);
    drawSmoothСurve(curve);
  });
}

function sendMaskState() {
  canvas.toBlob(function (blob) {
    wssConnection.send(blob);
    ctx.clearRect(0, 0, canvas.width, canvas.height);
  });
}

function throttleCanvas(callback, delay) {
  let isWaiting = false;
  return function () {
    if (!isWaiting) {
      isWaiting = true;
      setTimeout(() => {
        callback();
        isWaiting = false;
      }, delay);
    }
  }
}

function redraw () {
  if(newPaint) {
    repaint();
    newPaint = false;
  }
  window.requestAnimationFrame(redraw);
}
redraw();