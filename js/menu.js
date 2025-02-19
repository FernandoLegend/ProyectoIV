const expires = new Date(Date.now() + 30 * 24 * 60 * 60 * 1000).toUTCString();
const body = document.querySelector('body'),
home = document.getElementById('home'),
sidebar = body.querySelector('nav'),
togglea = body.querySelector(".toggle"),
searchBtn = body.querySelector(".search-box"),

modeSwitch = body.querySelector(".toggle-switch"),
modeText = body.querySelector(".mode-text");


function setCookie(name, value, days) {
  const expires = days ? `expires=${new Date(Date.now() + days * 864e5).toGMTString()}` : '';
  document.cookie = `${name}=${value}; ${expires}; path=/`;
}

function getCookie(name) {
  const value = `; ${document.cookie}`;
  const parts = value.split(`; ${name}=`);
  if (parts.length === 2) return parts.pop().split(';').shift();
}

function toggleTheme() {
  const body = document.body;
  const theme = getCookie('theme');

  if (theme === 'dark') {
    body.classList.remove('dark');
    setCookie('theme', '', -1); // Delete the cookie
  } else {
    body.classList.add('dark');
    setCookie('theme', 'dark', 30); // Set the cookie to expire in 30 days
  }
}

// Initialize the theme based on the cookie value
const initialTheme = getCookie('theme');
if (initialTheme === 'dark') {
  document.body.classList.add('dark');
}
      
      // Function to apply the theme
      function applyTheme(theme) {
        document.body.classList.add(theme);
      }
    togglea.addEventListener("click", () => {
        sidebar.classList.toggle("close");
    }) 
    
    searchBtn.addEventListener("click", () => {
        sidebar.classList.remove("close");
    })