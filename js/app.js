$(document).ready(function(){
    function getCookie(name){
        const value = "; " + document.cookie;
        const parts = value.split("; " + name + "=");
        if(parts.length === 2){
            return parts.pop();
        } else {
            return null;
        }
    }
    const loggedIn = getCookie("loggedIn");
    let username = getCookie("username");
    username = decodeURIComponent(username);

    if(loggedIn !== "true"){
        window.location.href = "login.php";
    } else {
        $(".content").show(); //This is important.  Keep this.
    }
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

// Event listener untuk dropdown Action (UPDATED)