
<!DOCTYPE html>
<html lang="sl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Miha Šafranko"/>
	<meta name="author" content="Miha Šafranko" />
    <title>Zavetišče</title>
    <style>
        body{
            background: linear-gradient(90deg, #C7C5F4, #776BCC);
        }
    </style>
</head>
<body>
  <?php
  require_once 'cookie.php';
  if(isset($_COOKIE['register'])){
      echo $_COOKIE['register'];
  }
  ?>
 <form action="register.php" method="get">
    <label for="ime">Ime:</label><br>
  <input type="text" id="ime" name="ime" required><br>
  <label for="priimek">Priimek:</label><br>
  <input type="text" id="priimek" name="priimek" required><br>
  <label for="email">Mail:</label><br>
  <input type="text" id="email" name="email" required><br>
  <label for="geslo">Geslo:</label><br>
  <input type="password" id="geslo" name="geslo" required><br>
  <label for="naslov">Naslov:</label><br>
  <input type="text" id="naslov" name="naslov" required><br>
  <label for="kraji">Kraj:</label><br>
  <input type="text" id="kraj" name = "kraj" list="kraji" required><br>  
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

</body>
</html>