<!DOCTYPE html>
<html lang="sl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Miha Šafranko"/>
	<meta name="author" content="Miha Šafranko" />
    <link rel="stylesheet" href="css/login.css">
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
  padding: 10px;
	font: inherit;
	box-shadow: 0 6px 10px 0 rgba(0, 0, 0 , .1);
	border-color: gray;
	outline: 0;
}

.container input[type="submit"] {
  width: 100%;
  padding: 10px;
  background-color: lightblue;
  color: #fff;
  border: none;
  border-radius: 4px;
  cursor: pointer;
}

.container input[type="submit"]:hover {
  background-color: lightblue;
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
  #errorWindow {
  position: fixed;
  bottom: 10px;
  right: 10px;
  width: 200px;
  min-height: 30px;
  background-color: lightcoral;
  display: none;
  padding: 10px;
  border-radius: 5px;
}
#warningWindow {
  position: fixed;
  bottom: 10px;
  right: 10px;
  width: 200px;
  min-height: 30px;
  background-color: lightblue;
  display: none;
  padding: 10px;
  border-radius: 5px;
}

#loginWindow {
    position: fixed;
    bottom: 10px;
    right: 10px;
    width: 200px;
    min-height: 30px;
    background-color: lightgreen;
    display: none;
    padding: 10px;
    border-radius: 5px;
}
</style>
<title>Zavetišče</title>
</head>
<body>
  <?php
  if(isset($_SESSION["id"])){
    header('Location: main.php');
  }
  ?>
<div class="container">
  <h1>Prijava</h1>
 <form action="preveri.php" method="get">
  <label for="email">Mail:</label>
  <input type="text" id="email" name="email"><br><br>
  <label for="geslo">Geslo:</label>
  <input type="password" id="geslo" name="geslo"><br><br>
  <input type="submit" value="Pošlji">
</form>
<p>Niste še uporabnik? <a href = "registracija.php">Pridobite dostop </a>

<form action = "brezprijave.php">
    <input type = "submit" value = "Dostop, brez prijave">
</form>
</div>

<?php
    if (isset($_COOKIE['prijava'])) {
       echo "<div id='loginWindow'>";
        echo "✅ ";
        echo $_COOKIE['prijava'];
        // setcookie("prijava", "", time() - 3600);
        echo "</div>";
    }
    ?>


    <?php
    
    if (isset($_COOKIE['prijava'])) {
        echo "<div id='errorWindow'>";
        echo "⛔ ";
        echo $_COOKIE['prijava'];
        // setcookie("prijava", "", time() - 3600);
        echo "</div>";
    }
    ?>


    <?php
    if (isset($_COOKIE['prijava'])) {
        echo "<div id='warningWindow'>";
        echo "⚠️ ";
        echo $_COOKIE['prijava'];
        // setcookie("prijava", "", time() - 3600);
        echo "</div>";
    }
    ?>
<script>
document.getElementById("errorWindow").style.display = "none";
document.getElementById("warningWindow").style.display = "none";
document.getElementById("loginWindow").style.display = "none";

// Check if cookie error is set to 1
if (getCookie("error") === "1") {
  document.getElementById("errorWindow").style.display = "block";
  setTimeout(function() {
    document.getElementById("errorWindow").style.display = "none";
  }, 5000); // Hide errorWindow after 5 seconds (adjust the time as needed)
}
// Check if cookie warning is set to 1
else if (getCookie("warning") === "1") {
  document.getElementById("warningWindow").style.display = "block";
  setTimeout(function() {
    document.getElementById("warningWindow").style.display = "none";
  }, 5000); // Hide warningWindow after 5 seconds (adjust the time as needed)
}
// If neither cookie is set to 1, show loginWindow
else if (getCookie("good") === "1"){
  document.getElementById("loginWindow").style.display = "block";
  setTimeout(function() {
    document.getElementById("loginWindow").style.display = "none";
  }, 5000); // Hide loginWindow after 5 seconds (adjust the time as needed)
}

// Function to get cookie value by name
function getCookie(name) {
  const cookies = document.cookie.split("; ");
  for (let i = 0; i < cookies.length; i++) {
    const cookie = cookies[i].split("=");
    if (cookie[0] === name) {
      return cookie[1];
    }
  }
  return "";
}

    document.cookie = 'prijava=; Max-Age=0';
    document.cookie = 'error=; Max-Age=0';
    document.cookie = 'warning=; Max-Age=0';
    document.cookie = 'good=; Max-Age=0';
</script>
</body>
</html>