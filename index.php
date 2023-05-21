<!DOCTYPE html>
<html lang="sl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Miha Šafranko"/>
	<meta name="author" content="Miha Šafranko" />
    <link rel="stylesheet" href="css/login.css">

    <title>Zavetišče</title>
</head>
<body>
    <?php
    if(isset($_COOKIE['prijava'])){
        echo $_COOKIE['prijava'];
        setcookie('prijava', '');
    }
    if(isset($_COOKIE['id'])){
        header('Location: index.php');
        exit();
    }
    ?>
<div class="container">
 <form action="preveri.php" method="get">
  <label for="fname">Mail:</label><br>
  <input type="text" id="email" name="email"><br>
  <label for="lname">Geslo:</label><br>
  <input type="password" id="geslo" name="geslo"><br>
  <input type="submit" value="Pošlji">
</form>
<p>Niste še uporabnik? <a href = "registracija.php">Pridobite dostop </a>
</div>

</body>
</html>