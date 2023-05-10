
<!DOCTYPE html>
<html lang="sl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Miha Šafranko"/>
	<meta name="author" content="Miha Šafranko" />
    <title>Spremembe</title>
</head>
<body>
  <?php
  require_once 'cookie.php';
  ?>
 <form action="register.php" method="get">
    <label for="ime">Ime:</label><br>
  <input type="text" id="ime" name="ime" required><br>
  <label for="datum">Datum rojstva:</label><br>
  <input type="date" id="datum" name="datum" required><br>
  <label for="posvojen">Posvojen:</label><br>
  <input type="checkbox" id="posvojen" name="posvojen" required><br>
  <label for="slika">Slika:</label><br>
  <input type="file" id="slika" name="slika" required><br>
  <label for="rezervacija">rezervacija:</label><br>
  <input type="list" id="uporabnikid" name = "uporabnikid" list="uporabniki"><br>  
  <datalist id="zivali">
    <?php
    require_once 'connect.php';
    $sql = "SELECT ime FROM zivali";
    $result = mysqli_query($conn, $sql);
    while ($row = mysqli_fetch_assoc($result)) {
      echo "<option value = ".$row['ime'].">";
    }
    setcookie('register', '');
    ?>
</datalist>
<datalist id = "uporabniki">
<?php
    require_once 'connect.php';
    $sql = "SELECT * FROM uporabniki";
    $result = mysqli_query($conn, $sql);
    while ($row = mysqli_fetch_assoc($result)) {
      echo "<option value = ".$row['email'].">";
    }
    setcookie('register', '');
    ?>
</datalist>
  <input type="submit" value="Pošlji">
</form>
<a href = "admin.php">Nazaj</a>

</body>
</html>