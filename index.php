<!DOCTYPE html>
<html lang="sl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Miha Šafranko"/>
	<meta name="author" content="Miha Šafranko" />
    <title>Zavetišče</title>
</head>
<body>
    <?php
        echo $_COOKIE['prijava'];
        setcookie('prijava', '');
    ?>
    <p>A se se dela?</p>
 <form action="preveri.php" method="get">
  <label for="fname">Mail:</label><br>
  <input type="text" id="email" name="email"><br>
  <label for="lname">Geslo:</label><br>
  <input type="password" id="geslo" name="geslo"><br>
  <input type="submit" value="Pošlji">
</form>
<p>Niste še uporabnik? <a href = "registracija.php">Pridobite dostop </a>

</body>
</html>