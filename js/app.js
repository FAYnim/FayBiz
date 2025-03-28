$(document).ready(function() {
  /*alert("Hello World!");*/
  // Coookies Function
  function getCookie(name) {
    let nameEQ = name + "=";
    let cookies = document.cookie.split(";");
    //alert(cookies);
    for (let i = 0; i < cookies.length; i++) {
      let c = cookies[i].trim();
      //alert(c);
      if (c.indexOf(nameEQ) === 0) {
        let cookieValue = c.substring(nameEQ.length);
        let decodeValue = decodeURIComponent(cookieValue);
        return decodeValue;
      } else {
        return null;
      }
    }
  }
  
  function deleteCookie(name) {
    document.cookie = name + "=; expires= Thu, 01 Jan 1970 00:00:00 UTC; path=/"
  }
  
  // Get Cookies
  const loggedIn = getCookie("loggedIn");
  let username = getCookie("username");
  
  if (loggedIn !== "true") {
    window.location.href = "login.php";
  } else {
    $(".content").show(); //This is important.  Keep this.
  }
  
  // Logout
  $("#logout").click(function(event) {
    event.preventDefault();
    
    deleteCookie("loggedIn");
    deleteCookie("username");
    
    window.location.href = "login.php"
  });
  
  // sidebar
  $(".has-submenu > a").click(function(event) {
    event.preventDefault();
    $(this).next(".submenu").slideToggle(300);
    return false;
  });
});

// Dropdown Onclick
$(document).on("click", ".btn-action", function(event) {
  //alert("Hello");
  event.stopPropagation();
  let dropdown = $(this).siblings(".dropdown-menu");
  
  if (dropdown.is(":visible")) {
    dropdown.fadeOut(150);
  } else {
    $(".dropdown-menu").fadeOut(150);
    dropdown.fadeIn(150);
  }
});
// Dropdown Offclick
$(document).click(function() {
  $(".dropdown-menu").fadeOut(150);
});
// Dropdown
$(document).on("click", ".dropdown-menu", function(event) {
  event.stopPropagation();
});


const sidebar = document.getElementById('sidebar');
const overlay = document.getElementById('overlay');
const hamburgerMenu = document.getElementById('hamburgerMenu');

hamburgerMenu.addEventListener('click', function() {
  sidebar.classList.toggle('active');
  overlay.classList.toggle('active');
});

overlay.addEventListener('click', function() {
  sidebar.classList.remove('active');
  overlay.classList.remove('active');
});