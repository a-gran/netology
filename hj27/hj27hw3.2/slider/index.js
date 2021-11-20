let slider = document.querySelector('.slider');
let visibleSlide = slider.getElementsByClassName('slide')[0];
visibleSlide.classList.add('slide-current');

let sliderNav = slider.querySelector('.slider-nav');
let prevButton = sliderNav.querySelector('[data-action=prev]');
let nextButton = sliderNav.querySelector('[data-action=next]');
let firstButton = sliderNav.querySelector('[data-action=first]');
let lastButton = sliderNav.querySelector('[data-action=last]');

prevButton.addEventListener('click', showSlide);
firstButton.addEventListener('click', showSlide);
lastButton.addEventListener('click', showSlide);
nextButton.addEventListener('click', showSlide);
updateSliderButtons();

function showSlide(event) {
  let btnDisabled = event.currentTarget.classList.contains('disabled');
  if (btnDisabled) {
    return;
  }
  visibleSlide.classList.remove('slide-current');
  switch (event.currentTarget) {
    case prevButton:
      visibleSlide = visibleSlide.previousElementSibling;
      break;
    case nextButton:
      visibleSlide = visibleSlide.nextElementSibling;
      break;
    case firstButton:
      visibleSlide = visibleSlide.parentElement.firstElementChild;
      break;
    case lastButton:
      visibleSlide = visibleSlide.parentElement.lastElementChild;
      break;
}
visibleSlide.classList.add('slide-current');
updateSliderButtons();
}

function updateSliderButtons() {
  if (visibleSlide.previousElementSibling) {
    prevButton.classList.remove('disabled');
    firstButton.classList.remove('disabled');
  } else {
    prevButton.classList.add('disabled');
    firstButton.classList.add('disabled');
  }
  if (visibleSlide.nextElementSibling) {
    nextButton.classList.remove('disabled');
    lastButton.classList.remove('disabled');
  } else {
    nextButton.classList.add('disabled');
    lastButton.classList.add('disabled');
  }
}