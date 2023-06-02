<!DOCTYPE html>
<html lang="sl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Miha Šafranko"/>
	<meta name="author" content="Miha Šafranko" />
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
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

  .form__label {
  font-family: 'Roboto', sans-serif;
  font-size: 1.2rem;
  margin-left: 2rem;
  margin-top: 0.7rem;
  display: block;
  transition: all 0.3s;
  transform: translateY(0rem);
}
.form__input {
  font-family: 'Roboto', sans-serif;
  color: #333;
  font-size: 1.2rem;
	margin: 0 auto;
  padding: 1.5rem 2rem;
  border-radius: 0.2rem;
  background-color: rgb(255, 255, 255);
  border: none;
  width: 90%;
  display: block;
  border-bottom: 0.3rem solid transparent;
  transition: all 0.3s;
}

.form__input:placeholder-shown + .form__label {
  opacity: 0;
  visibility: hidden;
  -webkit-transform: translateY(-4rem);
  transform: translateY(-4rem);
}
    </style>

    <title>Zavetišče</title>
</head>
<body>
<div class="container">
  <h1>Prijava</h1>
 <form action="preveri.php" method="get">
  <label for="fname" class="form__label">Mail:</label>
  <input type="text" id="email" name="email" class="form__input" placeholder="Mail"><br><br>
  <label for="lname" class="form__label">Geslo:</label>
  <input type="password" id="geslo" name="geslo" class="form__input" placeholder="Geslo"><br><br>
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