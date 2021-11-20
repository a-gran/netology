# Задача 2. Новое представление

#### Возможность работать с формой обратной связи посредством API запросов

## Описание
Требуется добавить `JSON` формат представления: если POST запрос получен с параметром `?json=1` - ответ должен быть в формате JSON. JSON объект должен содержать те же данные, что и ответ для HTML формата (структура произвольная).

## Реализация
Для отправки POST запроса и вывода ответа можно использовать следующий код из консоли браузера на странице с формой:

```js
const data = {
    message: 'Обращение через форму',
    name: 'Василий',
    email: 'Vasya@rhyta.com',
}

fetch(window.location.href + '/?json=1', {
    method: 'POST',
    headers: {
        'Content-Type': 'application/x-www-form-urlencoded;charset=UTF-8'
    },
    body: Object.keys(data).map(key => {
        return encodeURIComponent(key) + '=' + encodeURIComponent(data[key]);
    }).join('&')
})
.then(response => response.json())
.then(console.log)

```
