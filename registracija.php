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
  <?php
  require_once 'cookie.php';
  if(isset($_COOKIE['register'])){
      echo $_COOKIE['register'];
  }
  ?>
  <div class = "container">
    <h1>Registracija</h1>
 <form action="register.php" method="get">
  <label for="ime">Ime:</label>
  <input type="text" id="ime" name="ime" required><br><br>
  <label for="priimek">Priimek:</label>
  <input type="text" id="priimek" name="priimek" required><br><br>
  <label for="email">Mail:</label>
  <input type="text" id="email" name="email" required><br><br>
  <label for="geslo">Geslo:</label>
  <input type="password" id="geslo" name="geslo" required><br><br>
  <label for="naslov">Naslov:</label>
  <input type="text" id="naslov" name="naslov" required><br><br>
  <label for="kraji">Kraj:</label>
  <input type="text" id="kraj" name = "kraj" list="kraji" required><br><br>
  <datalist id="kraji">
    <?php
    require_once 'connect.php';
    $sql = "SELECT kraj FROM kraji";
    $result = mysqli_query($conn, $sql);
    while ($row = mysqli_fetch_assoc($result)) {
      echo "<option value = ".$row['kraj'].">";
    }
    setcookie('register', '');
    ?>
</datalist>
  <input type="submit" value="Pošlji">
</form>
<p>Ste že uporabnik? <a href = "index.php">Pojdite na prijavo</a>
  </div>
</body>
</html>