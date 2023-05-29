<!DOCTYPE html>
<html lang="sl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Miha Šafranko"/>
	<meta name="author" content="Miha Šafranko" />
    <link rel="stylesheet" href="css/login.css">
    <style>
        body{
            background: linear-gradient(90deg, #C7C5F4, #776BCC);
        }
        /* Global Styles */
body {
    font-family: Arial, sans-serif;
    background: linear-gradient(90deg, #C7C5F4, #776BCC);	
    margin: 0;
    padding: 0;
  }
  
  .container {
  max-width: 400px;
  margin: 50px auto;
  padding: 20px;
  background-color: #fff;
  border-radius: 10px; /* Adding rounded corners */
  box-shadow: 0 0 20px rgba(0, 0, 0, 0.2); /* Increasing the box shadow */
}


  
  h1 {
    text-align: center;
    color: #333;
  }
  
  form {
    margin-top: 20px;
  }
  
  label {
    display: block;
    margin-bottom: 5px;
    color: #555;
  }
  
  .container input[type="text"],
.container input[type="password"] {
  width: 100%;
  box-sizing: border-box;
}

.container input[type="submit"] {
  width: 100%;
  padding: 10px;
  background-color: blue;
  color: #fff;
  border: none;
  border-radius: 4px;
  cursor: pointer;
}

.container input[type="submit"]:hover {
  background-color: lightblue;
}
#loginWindow {
    position: fixed;
    bottom: 10px;
    right: 10px;
    width: 200px;
    height: 100px;
    background-color: lightgreen;
    display: none;
    padding: 10px;
    border-radius: 5px;
}
  
  a {
    color: lightblue;
    text-decoration: none;
  }
  
  /* Responsive Styles */
  @media (max-width: 600px) {
    .container {
      max-width: 100%;
      margin: 20px;
      box-shadow: none;
    }
  }
  
    </style>

    <title>Zavetišče</title>
</head>
<body>
<div class="container">
  <h1>Prijava</h1>
 <form action="preveri.php" method="get">
  <label for="fname">Mail:</label>
  <input type="text" id="email" name="email"><br><br>
  <label for="lname">Geslo:</label>
  <input type="password" id="geslo" name="geslo"><br><br>
  <input type="submit" value="Pošlji">
</form>
<p>Niste še uporabnik? <a href = "registracija.php">Pridobite dostop </a>
</div>

<div id="loginWindow">
    <?php
    if (isset($_COOKIE['prijava'])) {
        echo $_COOKIE['prijava'];
        // setcookie("prijava", "", time() - 3600);
    }
    ?>
</div>
<script>
function checkCookie() {
        var name = "prijava=";
        var decodedCookie = decodeURIComponent(document.cookie);
        var cookieArray = decodedCookie.split(';');

        for (var i = 0; i < cookieArray.length; i++) {
            var cookie = cookieArray[i];
            while (cookie.charAt(0) === ' ') {
                cookie = cookie.substring(1);
            }
            if (cookie.indexOf(name) === 0) {
                return true;
            }
        }
        return false;
    }

    // Show the login window if the cookie exists
    if (checkCookie()) {
        var loginWindow = document.getElementById("loginWindow");
        loginWindow.style.display = "block";
        setTimeout(function () {
            loginWindow.style.display = "none";
        }, 5000);
    }
    document.cookie = 'prijava=; Max-Age=0';
</script>
</body>
</html>