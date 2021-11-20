let content = document.getElementById('content');
let xhr = new XMLHttpRequest();
xhr.open('GET', 'https://neto-api.herokuapp.com/book/');
xhr.send();

xhr.addEventListener('load', () => {
  let books = JSON.parse(xhr.responseText);
  for(let book of books) {
    let li = document.createElement('li');
    li.innerHTML = `<img src = '${book.cover.small}'>`;
    li.dataset.title = book.title;
    li.dataset.author = book.author.name;
    li.dataset.info = book.info;
    li.dataset.price = book.price;
    content.appendChild(li);
  }
});

onError = () => {
  console.log('Ошибка!!!');
}