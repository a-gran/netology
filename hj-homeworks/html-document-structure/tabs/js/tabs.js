let tabsNav = document.querySelector('.tabs-nav');
let tabsCont = document.querySelector('.tabs-content').children;
let tabChild = tabsNav.children;
let firstTab = tabsNav.firstElementChild;

Array.from(tabsCont).forEach((art, item) => {
  let copyTab = firstTab.cloneNode(true);
  let tab = tabsNav.appendChild(copyTab);
  tab.firstElementChild.textContent = art.dataset.tabTitle;
  tab.firstElementChild.classList.add(art.dataset.tabIcon);
  if (item > 0) { art.classList.add('hidden') }
});

function tabActive(event) {
  let currTab = document.querySelector('.ui-tabs-active');
  currTab.classList.remove('ui-tabs-active');
  event.currentTarget.classList.add('ui-tabs-active');
  Array.from(tabsCont).forEach(art => {
    art.classList.add('hidden');
    if (event.currentTarget.children[0].textContent === art.dataset.tabTitle) {
      art.classList.remove('hidden');
    }
  });
}

tabsNav.removeChild(firstTab);
tabsNav.firstElementChild.classList.add('ui-tabs-active');
Array.from(tabChild).forEach(tab => tab.addEventListener('click', tabActive));