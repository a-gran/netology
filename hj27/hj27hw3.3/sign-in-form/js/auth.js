'use strict';

const signIn = document.querySelector('.sign-in-htm');
const signUp = document.querySelector('.sign-up-htm');
const signInBut = signIn.querySelector('.button');
const signUpBut = signUp.querySelector('.button');
const signInErr = signIn.querySelector('.error-message');
const signUpErr = signUp.querySelector('.error-message');

const xhr = new XMLHttpRequest();

function signInEvent (event) {
  let entry =  {};
  const formData = new FormData(signIn);
  for (const [key, value] of formData) {
    entry[key] = value;
  }

  event.preventDefault();
  xhr.addEventListener('load', loading);
  xhr.open('POST', 'https://neto-api.herokuapp.com/signin');
  xhr.setRequestHeader('Content-Type', 'application/json');
  xhr.send(JSON.stringify(entry));

  function loading() {
    if (xhr.status !== 200) {
      console.log(`Ответ ${xhr.status}: ${xhr.statusText}`);
    } else {
      const response = JSON.parse(xhr.responseText);
      if (response.error) {
        signInErr.value = response.message;
      } else {
        signInErr.value = `Пользователь ${response.name} успешно авторизован`;
      }
    }
  }
}

function singUpEvent (event) {
  let entry =  {}
  const formData = new FormData(signUp);
  for (const [key, value] of formData) {
    entry[key] = value;
  }

  event.preventDefault();
  xhr.addEventListener('load', loading);
  xhr.open('POST', 'https://neto-api.herokuapp.com/signup');
  xhr.setRequestHeader('Content-Type', 'application/json');
  xhr.send(JSON.stringify(entry));

  function loading() {
    if (xhr.status !== 200) {
      console.log(`Ответ ${xhr.status}: ${xhr.statusText}`);
    } else {
      const response = JSON.parse(xhr.responseText);
      if (response.error) {
        signUpErr.value = response.message;
      } else {
        signUpErr.value = `Пользователь ${response.name} успешно зарегистрирован`;
      } 
    }
  }
}

signInBut.addEventListener('click', signInEvent);
signUpBut.addEventListener('click', singUpEvent);