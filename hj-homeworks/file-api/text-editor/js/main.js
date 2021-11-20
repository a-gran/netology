const throttle = ( handler, ms ) => {
  let timeout;
  return () => {
    clearTimeout( timeout );
    timeout = setTimeout( handler, ms );
  }
};
class TextEditor {
  constructor( container, storageKey = '_text-editor__content' ) {
    this.container = container;
    this.contentContainer = container.querySelector( '.text-editor__content' );
    this.hintContainer = container.querySelector( '.text-editor__hint' );
    this.filenameContainer = container.querySelector( '.text-editor__filename' );
    this.storageKey = storageKey;
    this.registerEvents();
    this.load( this.getStorageData());
  }
  registerEvents() {
    const save = throttle( this.save.bind( this ), 1000 );
    this.contentContainer.addEventListener( 'input', save );
    this.container.addEventListener( 'dragover', this.showHint.bind( this ) );
    this.hintContainer.addEventListener( 'dragleave', this.hideHint.bind( this ) );
    this.hintContainer.addEventListener( 'drop', this.loadFile.bind( this ) );
  }
  loadFile( event ) {
    event.preventDefault();
    this.hideHint();
    const textRegExp = /^text\//;
    const files = Array.from( event.dataTransfer.files );
    if ( textRegExp.test( files[0].type )){
      this.readFile( files[0] );
    } else {
      this.contentContainer.value = '';
      this.setFilename( 'Не подходит тип файла!' );
    }
  }
  readFile( file ) {
    const reader = new FileReader();
    this.contentContainer.value = '';
    reader.addEventListener( 'load', event => {
      this.contentContainer.value = event.target.result;
    });
    reader.readAsText( file );
    this.setFilename( file.name.replace(/(\.[^/.]+)+$/, "") );
  }
  setFilename( filename ) {
    this.filenameContainer.textContent = filename;
  }
  showHint( event ) {
    event.preventDefault();
    this.hintContainer.classList.add( 'text-editor__hint_visible' );
  }
  hideHint() {
    this.hintContainer.classList.remove( 'text-editor__hint_visible' );
  }
  load( value ) {
    this.contentContainer.value = value || '';
  }
  getStorageData() {
    return localStorage[ this.storageKey ];
  }
  save() {
    localStorage[ this.storageKey ] = this.contentContainer.value;
  }
}

new TextEditor( document.getElementById( 'editor' ));