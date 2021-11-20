'use strict'

// реализация базового класса Vector
class Vector {
  //конструктор объекта vector с координатами x и y
  constructor(x = 0, y = 0) {
    this.x = x; this.y = y;
  }

  // метод plus() создает и возвращает новый объект типа Vector, координаты которого будут суммой соответствующих координат суммируемых векторов
  plus(vector) {
    if(vector instanceof Vector === false) {
      throw new Error('Можно прибалять только вектор типа Vector');
    }
    let newVector = new Vector(vector.x + this.x, vector.y + this.y);
    return newVector;
  }

  // метод times() создает и возвращает новый объект типа Vector, координаты которого будут равны соответствующим координатам исходного вектора, умноженным на множитель
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

//должны быть определены свойства только для чтения left, top, right, bottom, 
//в которых установлены границы объекта по осям X и Y с учетом его расположения и размера
  get left()   { return this.pos.x; }
  get top()    { return this.pos.y; }
  get right()  { return this.pos.x + this.size.x; }
  get bottom() { return this.pos.y + this.size.y; }
  get type()   { return 'actor'; }

  // метод проверяет, пересекается ли текущий объект с переданным объектом
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

// реализация базового класса Level
class Level {
  constructor(grid =[], actors = []) {

    this.grid = grid;
    this.actors = actors;
    this.finishDelay = 1;
    this.height = this.grid.length;
    this.width = 0;
    this.width = Math.max(0, ...this.grid.map(x => x.length));
    this.status = null;

    for(let item of actors) {
      if(item.type === 'player') {
        this.player = item;
        break;
      }
    }
  }

  // определяет, расположен ли какой-то другой движущийся объект в переданной позиции
  actorAt(moveActor) {
    if((moveActor instanceof Actor === false) || (moveActor === undefined)) {
      throw new Error('Неверный тип аргумента');
    }
    return this.actors.find(actor => actor.isIntersect(moveActor));
  }

  // определяет, завершен ли уровень
  isFinished() {
    return (this.finishDelay < 0);
    return (this.status !== null);
  }

  // аналогично методу actorAt определяет, нет ли препятствия в указанном месте 
  // также этот метод контролирует выход объекта за границы игрового поля
  obstacleAt(pos, size) {
    if(size instanceof Vector === false) {
      throw new Error('переданный аргумент не является типом Vector');
    }
    if(pos instanceof Vector === false) {
      throw new Error('переданный аргумент не является типом Vector');
    }

    const borderLeftPlayingField  = Math.floor(pos.x);
    const borderUpPlayingField    = Math.ceil(pos.y +size.y);
    const borderRightPlayingField = Math.ceil(pos.x + size.x);
    const borderDownPlayingField  = Math.floor(pos.y);

    if(borderDownPlayingField  < 0)             { return 'wall' }
    if(borderLeftPlayingField  < 0)             { return 'wall' }
    if(borderRightPlayingField > this.width)    { return 'wall' }
    if(borderUpPlayingField    > this.height)   { return 'lava' }

    for(let y = borderDownPlayingField; y < borderUpPlayingField; y++) {
      for(let x = borderLeftPlayingField; x < borderRightPlayingField; x++) {
        let obs = this.grid[y][x];
        if(obs) {
          return obs;
        }
      }
    }
  }

  // определяет, остались ли еще объекты переданного типа на игровом поле
  noMoreActors(typeMoveActor) {
    return !this.actors.find(actor => actor.type === typeMoveActor);
  }

  // метод удаляет переданный объект с игрового поля 
  // если такого объекта на игровом поле нет, не делает ничего
  removeActor(moveActor) {
    if(moveActor instanceof Actor === false) {
      throw new Error('переданный аргумент не является типом Vector');
    }
    this.actors = this.actors.filter(item => item !== moveActor);
  }

  // один из ключевых методов, определяющий логику игры 
  // меняет состояние игрового поля при касании игроком каких-либо объектов или препятствий
  playerTouched(typeObj, moveActor) {
    if(typeObj === 'fireball') {
      this.status = 'lost';
    }
    else if(typeObj === 'lava') {
      this.status = 'lost';
    }
    else if(typeObj === 'coin') {
      this.removeActor(moveActor);
        if(this.noMoreActors('coin')) {
          this.status = 'won';
      }
    }
    return this.status === null;
  }
}

// реализация класса Player
class Player extends Actor {
  constructor(pos = new Vector(0, 0)) {
    super(pos.plus(new Vector(0, -0.5)), new Vector(0.8, 1.5));
  }

  get type() {return 'player'}
}

// реализация класса LevelParser
class LevelParser {
  constructor(dict) {
    this.dict = Object.assign({}, dict);
  }

  actorFromSymbol(symbol) {
    if (symbol === undefined) {
      return undefined;
    }
    return this.dict[symbol];
  }

  obstacleFromSymbol(symbol) {
    if(symbol === '!') {
      return 'lava';
    }
    else if(symbol === 'x') {
      return 'wall';
    }
  }

  createGrid(plan) {
    return plan.map(range => range.split('')
            .map(symbol => this.obstacleFromSymbol(symbol)));
  }

  parse(arrOfStrings) {
    return new Level(this.createGrid(arrOfStrings), this.createActors(arrOfStrings));
  }


  createActors(arrOfStrings) {
    let actors = [];
    arrOfStrings.map(item => item.split(''))
      .forEach((range, y) => {
        range.forEach((col, x) => {
          let constructor = this.actorFromSymbol(col);
            if(typeof constructor === 'function') {
              let actor = new constructor(new Vector(x, y));
                if(actor instanceof Actor) {
                  actors.push(actor);
                }
              }
            });
          });
    return actors;
  }
}

// реализация класса Fireball
class Fireball extends Actor {
  constructor(pos = new Vector(0, 0), speed = new Vector(0, 0)) {
    super(pos, new Vector(1, 1), speed);
  }

  get type() { return 'fireball' }

  handleObstacle() {
    this.speed = this.speed.times(-1);
  }

  getNextPosition(n = 1) {
    return this.pos.plus(this.speed.times(n));
  }

  act(time, level) {
    let newPosition = this.getNextPosition(time);

    if(level.obstacleAt(newPosition, this.size)) {
      this.handleObstacle();
    } else { this.pos = newPosition }
  }
}

// реализация класса VerticalFireball
class VerticalFireball extends Fireball {
  constructor(pos = new Vector(0, 0)) {
    super(pos, new Vector(0, 2));
  }
}

// реализация класса HorizontalFireball
class HorizontalFireball extends Fireball {
  constructor(pos = new Vector(0, 0)) {
    super(pos, new Vector(2,0));
  }
}

// реализация класса FireRain
class FireRain extends Fireball {
  constructor(pos = new Vector(0, 0)) {
    super(pos, new Vector(0, 3));
    this.startPosition = this.pos;
  }

  handleObstacle() {
    this.pos = this.startPosition;
  }
}

// реализация класса Coin
class Coin extends Actor {
  constructor(pos = new Vector()) {
    super(pos.plus(new Vector(0.2, 0.1)), new Vector(0.6, 0.6));
    this.springDist = 0.07;
    this.springSpeed = 8;
    this.spring = Math.random() * (Math.PI * 2);
    this.startPosition = this.pos;

  }

  get type() { return 'coin' }

  getSpringVector() {
    return new Vector(0, this.springDist * Math.sin(this.spring));
  }

  updateSpring(time = 1) {
    this.spring += this.springSpeed * time;
  }

  getNextPosition(time = 1) {
      this.updateSpring(time);
      return this.startPosition.plus(this.getSpringVector());
    }

  act(time) {
    this.pos = this.getNextPosition(time);
  }
}

const actorDict = {
  '@': Player,
  'h': HorizontalFireball,
  'o': Coin,
  'v': VerticalFireball,
  'f': FireRain
};

const parser = new LevelParser(actorDict);
loadLevels().then(json =>
  runGame(JSON.parse(json), parser, DOMDisplay))
    .then(() => alert('Вы выиграли приз!'));
