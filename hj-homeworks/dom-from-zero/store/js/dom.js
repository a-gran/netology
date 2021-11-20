function createElement(node) {
  let unit = document.createElement(node.name);
  if (typeof node.props === 'object' && node.props !== null) {
    Object.keys(node.props).forEach(i => unit.setAttribute(i, node.props[i]));
  }
  if (typeof node === 'string') {
    return document.createTextNode(node);
  }
  if (node.childs instanceof Array) {
    node.childs.forEach(child => {
      const childEl = createElement(child);
      unit.appendChild(childEl);
    });
  } return unit;
}