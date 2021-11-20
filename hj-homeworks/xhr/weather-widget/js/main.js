let request = new XMLHttpRequest();
request.addEventListener('load', loading);
request.open('GET', 'https://netology-fbb-store-api.herokuapp.com/weather');
request.send();
function loading() {
  if (request.status === 200) {
    let response = JSON.parse(request.responseText);
    setData(response);
  }
}