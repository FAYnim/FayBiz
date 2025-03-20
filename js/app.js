$(document).ready(function(){
    // Coookies Function
    function getCookie(name){
        let nameEQ = name + "=";
        let cookies = document.cookie.split(";");
        //alert(cookies);
        for(let i = 0; i < cookies.length; i++){
            let c = cookies[i].trim();
            //alert(c);
            if(c.indexOf(nameEQ) === 0){
                let cookieValue = c.substring(nameEQ.length);
                let decodeValue = decodeURIComponent(cookieValue);
                return decodeValue;
            } else {
                return null;
            }
        }
    }
    
    function deleteCookie(name){
        document.cookie = name + "=; expires= Thu, 01 Jan 1970 00:00:00 UTC; path=/"
    }
    
    // Get Cookies
    const loggedIn = getCookie("loggedIn");
    let username = getCookie("username");

    if(loggedIn !== "true"){
        window.location.href = "login.php";
    } else {
        $(".content").show(); //This is important.  Keep this.
    }
    
    // Logout
    $("#logout").click(function(event){
        event.preventDefault();
        
        deleteCookie("loggedIn");
        deleteCookie("username");
        
        window.location.href = "login.php"
    });
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