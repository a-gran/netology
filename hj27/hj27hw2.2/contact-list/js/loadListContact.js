'strict'

let contacts = loadContacts();
let items = JSON.parse(contacts);
let contactList = document.getElementsByClassName('contacts-list')[0];

for(const item of items) {
  let li = document.createElement('li');
  li.innerHTML = `<strong>${item.name}</strong>`;
  li.dataset.phone = item.phone;
  li.dataset.email = item.email;
  contactList.appendChild(li);
}