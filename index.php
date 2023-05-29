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
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
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
  background-color: #ffffff;
  color: #fff;
  border: none;
  border-radius: 4px;
  cursor: pointer;
}

.container input[type="submit"]:hover {
  background-color: #f1f1f1;
}
  
  a {
    color: #ffffff;
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
    if(isset($_COOKIE['prijava'])){
        echo $_COOKIE['prijava'];
        setcookie('prijava', '');
    }
    ?>
<div class="container">
 <form action="preveri.php" method="get">
  <label for="fname">Mail:</label><br>
  <input type="text" id="email" name="email"><br>
  <label for="lname">Geslo:</label><br>
  <input type="password" id="geslo" name="geslo"><br><br>
  <input type="submit" value="Pošlji">
</form>
<p>Niste še uporabnik? <a href = "registracija.php">Pridobite dostop </a>
</div>

</body>
</html>