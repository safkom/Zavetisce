
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
  require_once 'connect.php';
  $sql = "SELECT * from zivali WHERE id = ".$_GET['zival_id'].";";
  $result = mysqli_query($conn, $sql);
  $row = mysqli_fetch_array($result)?>
 <form action="register.php" method="get">
    <label for="ime">Ime:</label><br>
  <input type="text" id="ime" name="ime" value = "<?php echo $row['ime']?>" required><br>
  <label for="datum">Datum rojstva:</label><br>
  <input type="date" id="datum" name="datum" value = "<?php echo $row['datum_r']?>" required><br>
  <label for="posvojen">Posvojen:</label><br>
  <input type="checkbox" id="posvojen" name="posvojen" <?php if($row['posvojen']== 1){echo "checked";}?> required><br>
  <label for="slika">Slika:</label><br>
  <input type="file" id="slika" name="slika" required><br>
  <label for="rezervacija">rezervacija:</label><br>
  <input type="list" id="uporabnikid" name = "uporabnikid" value = "<?php
    $sql = "SELECT * from rezervacija WHERE zival_id = '".$_GET['zival_id']."';";
    $result = mysqli_query($conn, $sql);
    while ($row = mysqli_fetch_array($result)) {
      echo $row['uporabnik_id'];
      $datum_rez = $row['datum'];
    }?>
    " list="uporabniki"><br>  
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