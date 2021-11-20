let wallpaper = document.querySelector('[data-wallpaper]');
let description = document.querySelector('[data-description]');
let username = document.querySelector('[data-username]');
let tweets = document.querySelector('[data-tweets]');
let pic = document.querySelector('[data-pic]');
let following = document.querySelector('[data-following]');
let followers = document.querySelector('[data-followers]');
let url = `https://neto-api.herokuapp.com/twitter/jsonp`;
let script = document.createElement('script');
script.setAttribute('src', url);

function callback (userData) {
  wallpaper.src = userData.wallpaper;
  username.textContent = userData.username;
  description.textContent = userData.description;
  pic.src = userData.pic;
  tweets.value = userData.tweets;
  followers.value = userData.followers;
  following.value = userData.following;
}

document.body.appendChild(script);