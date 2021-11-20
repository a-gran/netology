'use strict';

let contForm = document.getElementsByClassName('contentform')[0];
let outReport = document.getElementById('output');
let edit = document.getElementsByClassName('button-contact')[1];
let send = document.getElementsByClassName('button-contact')[0];
let userEmail = document.querySelector('input[name=email]');
let userLastName = document.querySelector('input[name=lastname]');
let userName = document.querySelector('input[name=name]');
let userAddress = document.querySelector('input[name=address]');
let userCompany = document.querySelector('input[name=company]');
let userCity = document.querySelector('input[name=city]');
let userZip = document.querySelector('input[name=zip]');
let userPhone = document.querySelector('input[name=phone]');
let userTheme = document.querySelector('input[name=subject]');
let userRole = document.querySelector('input[name=role]');
let outputs = document.querySelectorAll('#output output' );
let userReport = document.querySelector('textarea[name=message]');

let items = [
  userLastName,
  userName,
  userCompany,
  userEmail,
  userAddress,
  userCity,
  userZip,
  userRole,
  userReport,
  userPhone,
  userTheme
];

function userValidateZip() {
  userZip.value = userZip.value.replace(/[^\d,]/g, '')
}

function filled() {
  if(items.some(item => !item.dataset.check === true)) {
    send.setAttribute('disabled', 'disabled');
    } else {
    send.removeAttribute('disabled'); 
  }
}

function outputFilled() {
  for(let item of items) {
    if(document.getElementById(item.name)) {
      document.getElementById(item.name).value = item.value;
    }
  }
}

send.addEventListener('click', function(event) {
  event.preventDefault();
  outReport.classList.toggle('hidden');
  contForm.classList.add('hidden');
  outputFilled();
})

edit.addEventListener('click', function(event){
  event.preventDefault();
  outReport.classList.toggle('hidden');
  contForm.classList.remove('hidden');
})

userZip.addEventListener('input', userValidateZip)
for(let item of items){
  item.addEventListener('input', function(){
    if(!(item.value === '')){
      item.dataset.check = true;
      filled();
    } else {
       item.removeAttribute("data-check");
       filled();
    }
  });
}