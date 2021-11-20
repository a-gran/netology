'use strict';

function handleTableClick(event) {
  if(event.target.tagName !== 'TH') {
    return;
  }

  let intention = event.target;
  let denotation = intention.dataset.propName;
  table.dataset.sortBy = denotation;

  if (intention.dataset.dir === undefined || intention.dataset.dir === '-1') {
    intention.dataset.dir = '1';
  } else {
    intention.dataset.dir = '-1';
  }
  sortTable(denotation, intention.dataset.dir);
}
