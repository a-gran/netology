'use strict';

function commentaryList(list) {
  let selectCom = document.querySelector('.comments');
  let newComm = list.map(addCom);
  newComm.forEach(elem => selectCom.appendChild(elem));
}

function addCom(com) {
  let listOfText = com.text.split('\n');
  return elemTag('div', {class: 'comment-wrap'}, [
    elemTag('div', {class: 'photo', title: com.author.name}, [
      elemTag('div', {class: 'avatar', style: `background-image: url('${com.author.pic}')`})
    ]),
    elemTag('div', {class: 'comment-block'}, [
      elemTag('p', {class: 'comment-text'}, listOfText.map(elem => {
        let br = elemTag('br');
        let span = elemTag('span');
        span.textContent = elem;
        span.appendChild(br);
        return span;
      })),
      elemTag('div', {class: 'bottom-comment'}, [
        elemTag('div', {class: 'comment-date'}, new Date(com.date).toLocaleString('ru-Ru')),
        elemTag('ul', {class: 'comment-actions'}, [
          elemTag('li', {class: 'complain'}, 'Пожаловаться'),
          elemTag('li', {class: 'reply'}, 'Ответить')
        ])
      ])
    ])
  ]);
}

function elemTag(tagName, attribut, child) {
  let unit = document.createElement(tagName);
  if (typeof attribut === 'object') {
    Object.keys(attribut).forEach(i => unit.setAttribute(i, attribut[i]));
  }
  if (child instanceof Array) {
    child.forEach(child => unit.appendChild(child));
  } else if (typeof child === 'string') {
    unit.textContent = child;
  } return unit;
}

fetch('https://neto-api.herokuapp.com/comments').then(res => res.json()).then(commentaryList);