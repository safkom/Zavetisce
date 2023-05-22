<!DOCTYPE html>
<html lang="sl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Miha Šafranko"/>
	<meta name="author" content="Miha Šafranko" />
  <link rel="stylesheet" type="text/css" href="css/spremembe.css">

    <title>Spremembe</title>
</head>
<body>
  <?php
  require_once 'cookie.php';
  require_once 'connect.php';
  $zival = $_GET['zival_id'];
  setcookie('zival_id', $zival);
  $sql = "SELECT * from zivali WHERE id = ".$_GET['zival_id'].";";
  $result = mysqli_query($conn, $sql);
  $row = mysqli_fetch_array($result)?>
<div class="container">
	<div class="screen">
		<div class="screen__content">
			<form class="login" id = "spremembe" action="change.php" method="post" enctype="multipart/form-data">
				<div class="login__field">
					<i class="login__icon fas fa-user"></i>
					<label for="ime">Ime:</label><br>
                    <input type="text" id="ime" name="ime" value = "<?php echo $row['ime']?>" required><br>
				</div>
				<div class="login__field">
					<i class="login__icon fas fa-lock"></i>
					<label for="datum">Datum rojstva:</label><br>
                    <input type="date" id="datum" name="datum" class = login_input value = "<?php echo $row['datum_r']?>" required><br>
				</div>
                <div class="login__field">
					<i class="login__icon fas fa-lock"></i>
					<label for="posvojen">Posvojen:</label><br>
                    <input type="checkbox" id="posvojen" name="posvojen" class="login_input" <?php if($row['posvojen']== 1){echo "checked";}?>><br>
				</div>
                <div class="login__field">
					<i class="login__icon fas fa-lock"></i>
					<label for="slika">Slika:</label><br>
                    <input type="file" id="slika" class="login_input" name="slika"><br>
				</div>
                <div class="login__field">
					<i class="login__icon fas fa-lock"></i>
					<label for="rezervacija">Rezervacija:</label><br>
  <input type="datalist" id="uporabnikid" class="login_input" name="uporabnikid" value="<?php
    $sql = "SELECT * from rezervacija WHERE zival_id = ".$_GET['zival_id'].";";
    $result = mysqli_query($conn, $sql);
    $rows = mysqli_num_rows($result);
    $rezervacija = 0;

    if ($rows === 0) {
        echo ""; // Display nothing if rezervacija doesn't exist
    } else {
        while ($row = mysqli_fetch_array($result)) {
            $uporabnik_id = $row['uporabnik_id'];
            $datum_rez = $row['datum'];
            $rezervacija = 1;
        }
        if ($rezervacija === 1) {
            $sql = "SELECT * from uporabniki WHERE id = ".$uporabnik_id.";";
            $result2 = mysqli_query($conn, $sql); // Use a different variable for the second query result
            while ($row = mysqli_fetch_array($result2)) { // Loop through the second result
                echo $row['email'];
            }
        }
    }

?>" list="uporabniki">
<br>

<br>
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
				</div>
				<button class="button login__submit">
					<span class="button__text">Pošlji</span>
					<i class="button__icon fas fa-chevron-right"></i>
				</button>				
			</form>
		</div>
		<div class="screen__background">
			<span class="screen__background__shape screen__background__shape4"></span>
			<span class="screen__background__shape screen__background__shape3"></span>		
			<span class="screen__background__shape screen__background__shape2"></span>
			<span class="screen__background__shape screen__background__shape1"></span>
		</div>		
	</div>
</div>