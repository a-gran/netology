'use strict';

let ws = new WebSocket('wss://neto-api.herokuapp.com/chat');
let chat = document.querySelector('.chat');
let chatStatus = chat.querySelector('.chat-status');
let sendMessage = chat.querySelector('.message-submit');
let сontMessage = chat.querySelector('.messages-content');
let [MESSAGE_OTHER, MESSAGE_PERSONAL, MESSAGE_NOTICE, MESSAGE_LOADING] = ['other', 'personal', 'notice', 'loading'];

ws.addEventListener('open', success);
ws.addEventListener('message', newMessage);
ws.addEventListener('close', statusOffline);

window.addEventListener('beforeunload', () => {
  ws.close(1000, 'User left');
});
sendMessage.addEventListener('click', submitMessage);
document.querySelector('.messages').style.overflowY = 'auto';
сontMessage.style.height = '100%';

function success() {
  chatStatus.innerText = chatStatus.dataset.online;
  addMessage('User online', MESSAGE_NOTICE);
  sendMessage.disabled = false;
}

function statusOffline() {
  chatStatus.innerText = chatStatus.dataset.offline;
  addMessage('User offline', MESSAGE_NOTICE);
  sendMessage.disabled = true;
}

function newMessage(event) {
  if (event.data !== '...' ) {
    let loadingMessage = сontMessage.querySelector('.message.loading');
    if (loadingMessage) {
      loadingMessage.parentNode.removeChild(loadingMessage);
    }
    addMessage(event.data, MESSAGE_OTHER);
  } else {
    addMessage(event.data, MESSAGE_LOADING);
  }
}

function submitMessage(event) {
  event.preventDefault();
  let messageInput = chat.querySelector('.message-input');
  let message = messageInput.value;
  if (message !== '') {
    addMessage(message, MESSAGE_PERSONAL);
    console.log(currentTime());
    ws.send(message);
    messageInput.value = '';
  }
}

function currentTime() {
  let now = new Date();
  return now.toLocaleTimeString('ru-RU', { hour12: false }).substring(0, 5);
}

function returnTemplate(messageType = MESSAGE_OTHER) {
  let templates = chat.querySelector('.messages-templates');
  switch (messageType) {
    case MESSAGE_PERSONAL:
      return templates.querySelector('.message.message-personal').cloneNode(true);
    case MESSAGE_NOTICE:
      return templates.querySelector('.message.message-status').cloneNode(true);
    case MESSAGE_LOADING:
      return templates.querySelector('.message.loading').cloneNode(true);
    default:
      return Array.from(templates.querySelectorAll('.message')).find(template => {
        if (template.classList.length === 1) return template;
      }).cloneNode(true);
  }
}

function addMessage(message = '', messageType = MESSAGE_SELF, time = currentTime()) {
  let msgTemplate = returnTemplate(messageType);
    console.log(msgTemplate, messageType);
    msgTemplate.querySelector('.message-text').innerText = message;
    if (messageType !== MESSAGE_NOTICE) {
      msgTemplate.querySelector('.timestamp').innerText = time;
    }
    сontMessage.appendChild(msgTemplate);
}