const addClass = ( className, context ) => context.classList.add( className ),
      removeClass = ( className, context ) => context.classList.remove( className ),
      hasClass = ( className, context ) => context.classList.contains( className );
class iLayout {
  constructor( container ) {
    this.container = container;
    this.positionsContainer = container.querySelector( '.layout__positions' );
    this.actionButton = container.querySelector( '.layout__button' );
    this.result = container.querySelector( '.layout__result' );
    this.layout = {
      left: null,
      top: null,
      bottom: null
    };
    this.registerEvents();
  }
  registerEvents() {
    this.positionsContainer.addEventListener( 'dragover', this.showTargetZone.bind( this ) );
    this.positionsContainer.addEventListener( 'dragleave', this.hideTargetZone.bind( this ) );
    this.positionsContainer.addEventListener( 'drop', this.loadFile.bind( this ) );
    this.actionButton.addEventListener( 'click', this.getRes.bind( this ) );
  }
  loadFile( event ) {
    event.preventDefault();
    this.hideTargetZone();
    let imageTypeRegExp = /^image\//;
    let files = Array.from( event.dataTransfer.files );
    if ( imageTypeRegExp.test( files[0].type )){
      event.target.textContent = ''
      this.insertImg( files[0], event.target )
      this.result.textContent = ''
    } else {
      this.result.textContent =  'Это не картинка!';
    }
  }
  insertImg( file, element ) {
    event.preventDefault();
    if ( hasClass( 'layout__image', element )) {
      element.src = URL.createObjectURL(file);
    } else {
      let img = document.createElement( 'img' );
      img.src = URL.createObjectURL( file );
      img.className = 'layout__image';
      element.appendChild( img );
    }
  }
  getRes() {
    const canvas = document.createElement('canvas');
    const ctx = canvas.getContext('2d');
    const imagesForCollage = this.positionsContainer.querySelectorAll('.layout__item')
    canvas.width = this.positionsContainer.offsetWidth;
    canvas.height = this.positionsContainer.offsetHeight;
    Array.from(imagesForCollage).forEach(el => {
        let boundEl = el.parentElement.getBoundingClientRect()
        let x =  Math.abs( Math.round( el.offsetLeft - boundEl.left) )
        let y =   Math.abs( Math.round( el.offsetTop - boundEl.top) )
        let img = new Image()
        img.src = el.querySelector('img').src
        ctx.drawImage( img, x, y, el.offsetWidth, el.offsetWidth * img.height / img.width );
    });
    this.result.innerText = `<img  src="${canvas.toDataURL()}" alt="iLayout">`;
  }
  showTargetZone() {
    event.preventDefault()
    addClass( 'layout__item_active', event.target );
  }
  hideTargetZone() {
    event.preventDefault()
    removeClass( 'layout__item_active', event.target );
  }
}

new iLayout( document.getElementById( 'layout' ));