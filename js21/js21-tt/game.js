'use strict';

// реализация базового класса вектор

class Vector {
  //конструктор объекта vector с координатами x и y
  constructor(x = 0, y = 0) {
    this.x = x; this.y = y;
  }

  // метод plus() создает и возвращает новый объект типа Vector, координаты которого будут суммой соответствующих координат суммируемых векторов.
  plus(vector) {
    if(vector instanceof Vector === false) {
      throw new Error('Можно прибалять только вектор типа Vector');
    }
    let newVector = new Vector(vector.x + this.x, vector.y + this.y);
    return newVector;
  }

  // метод times() создает и возвращает новый объект типа Vector, координаты которого будут равны соответствующим координатам исходного вектора, умноженным на множитель.
  times(numeric) {
    if(typeof(numeric) !== 'number') {
      throw new Error('В качестве множителя должно передаваться число!');
    }
    let output = new Vector;
    output.y = numeric * this.y;
    output.x = numeric * this.x;
    return output;
  }
} 




//пример из ТЗ для вектор

// const start = new Vector(30, 50);
// const moveTo = new Vector(5, 10);
// const finish =start.plus(moveTo.times(2));
// console.log(`Исходное расположение: ${start.x}:${start.y}`);
// console.log(`Текущее расположение: ${finish.x}:${finish.y}`);



// реализация базового класса Actor

class Actor {
  // конструктор движущегося объекта 
  constructor(pos = new Vector(), size = new Vector(1, 1), speed = new Vector()) {
    if((size instanceof Vector === false) || (pos instanceof Vector === false) || (speed instanceof Vector === false)) {
      throw new Error('В качестве аргумента передан не Vector!');
    }
    this.size = size;
    this.pos = pos;
    this.speed = speed;
  }

  act() {}

//Должны быть определены свойства только для чтения left, top, right, bottom, 
//в которых установлены границы объекта по осям X и Y с учетом его расположения и размера.
  get left()   { return this.pos.x; }
  get top()    { return this.pos.y; }
  get right()  { return this.pos.x + this.size.x; }
  get bottom() { return this.pos.y + this.size.y; }

  get type()   { return 'actor'; }

  isIntersect(moveActor) {
    if(moveActor === undefined || moveActor instanceof Actor === false) {
      throw new Error('Передан не Actor!');
    }
    else if(this === moveActor || this.left >= moveActor.right ||
            this.top >= moveActor.bottom || this.right <= moveActor.left ||
            this.bottom <= moveActor.top) {
               return false;
            } else return true;
  }
}



// пример из ТЗ для Actor

// const items = new Map();
// const player = new Actor();
// items.set('Игрок', player);
// items.set('первая монета', new Actor(new Vector(10, 10)));
// items.set('Вторая монета', new Actor(new Vector(15, 5)));

// function position(item) {
//   return ['left', 'top', 'right', 'bottom'].map(side => `${side}: ${item[side]}`).join(', ');
// }

// function movePlayer(x, y) {
//   player.pos = player.pos.plus(new Vector(x, y));
// }

// function status(item, title) {
//   console.log(`${title}: ${position(item)}`);
//   if(player.isIntersect(item)) {
//     console.log(`Игрок подобрал ${title}`);
//   }
// }

// items.forEach(status);
// movePlayer(10, 10);
// items.forEach(status);
// movePlayer(5, -5);
// items.forEach(status);



// реализация базового класса Level

class Level {
  constructor(grid =[], actors = []) {
    this.grid = grid;
    this.actors = actors;
    this.finishDelay = 1;
    this.height = this.grid.length;
    this.width = 0;
    this.status = null;
    for(let item of actors) {
      if(item.type === 'player') {
        this.player = item;
        break;
      }
    }
  }

  actorAt(moveActor) {
    if((moveActor instanceof Actor === false) || (moveActor === undefined)) {
      throw new Error('Неверный тип аргумента');
    }
    return this.actor;
  }

  // isFinished() {
  //  this.finishDelay < 0 ? true : false;
  //  this.status !== null ? true : false;
  // }

  isFinished() {
    if(this.finishDelay < 0) {
      return true;
    } else {
      return false;
    }
    if(this.status !== null) {
      return true;
    } else {
      return false;
    }
  }

  obstacleAt(pos, size) {
    if(size instanceof Vector === false) {
      throw new Error('переданный аргумент не является типом Vector');
    }
    if(pos instanceof Vector === false) {
      throw new Error('переданный аргумент не является типом Vector');
    }
    // const borderLeftPlayingField  = 
    // const borderUpPlayingField    = 
    // const borderRightPlayingField = 
    // const borderDownPlayingField  = 

  }

  noMoreActors(typeMoveActor) {
    if(typeof(typeMoveActor) !== 'string') {
      throw new Error('переданный аргумент не является строкой');
    }

  }

  removeActor(moveActor) {
    if(moveActor instanceof Actor === false) {
      throw new Error('переданный аргумент не является типом Vector');
    }

  }

  playerTouched(typeObj, moveActor) {
    if(typeObj === 'fireball') {
      this.status = 'lost';
    }
    else if(typeObj === 'lava') {
      this.status = 'lost';
    }
    else if(typeObj === 'coin') {

    }
  }

}



