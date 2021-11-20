let todoList = document.querySelector('.todo-list');
let inputs = todoList.querySelectorAll('input');
let undone = todoList.querySelector('.undone');
let done = todoList.querySelector('.done');

function show() {
  if (this.checked) {
      done.appendChild(this.parentElement)
  } else {
      undone.appendChild(this.parentElement);
  }
}

Array.from(inputs).forEach(input => input.addEventListener('click', show));