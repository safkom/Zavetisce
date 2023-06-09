// Check if the cookie 'prijava' exists
function checkCookie() {
    var name = "prijava=";
    var decodedCookie = decodeURIComponent(document.cookie);
    var cookieArray = decodedCookie.split(';');
    
    for (var i = 0; i < cookieArray.length; i++) {
        var cookie = cookieArray[i];
        while (cookie.charAt(0) == ' ') {
            cookie = cookie.substring(1);
        }
        if (cookie.indexOf(name) == 0) {
            return true;
        }
    }
    return false;
}

// Show the login window if the cookie exists
if (checkCookie()) {
    var loginWindow = document.getElementById("loginWindow");
    loginWindow.style.display = "block";
    setTimeout(function() {
        loginWindow.style.display = "none";
    }, 5000);
}