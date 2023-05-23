<!DOCTYPE html>
<html lang="sl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Miha Šafranko"/>
	<meta name="author" content="Miha Šafranko" />
  <link rel="stylesheet" type="text/css" href="css/spremembe.css">

    <title>Vnos</title>
</head>
<body>
  <?php
  require_once 'cookie.php';
  require_once 'connect.php'; ?>
<div class="container">
	<div class="screen">
		<div class="screen__content">
			<form class="login" id = "spremembe" action="novo.php" method="post" enctype="multipart/form-data">
				<div class="login__field">
					<i class="login__icon fas fa-user"></i>
					<label for="ime">Ime:</label><br>
                    <input type="text" id="ime" name="ime" required><br>
				</div>
				<div class="login__field">
					<i class="login__icon fas fa-lock"></i>
					<label for="datum">Datum rojstva:</label><br>
                    <input type="date" id="datum" name="datum" class = login_input  required><br>
				</div>
                <div class="login__field">
					<i class="login__icon fas fa-lock"></i>
					<label for="posvojen">Posvojen:</label><br>
                    <input type="checkbox" id="posvojen" name="posvojen" class="login_input" ><br>
				</div>
                <div class="login__field">
					<i class="login__icon fas fa-lock"></i>
					<label for="slika">Slika:</label><br>
                    <input type="file" id="slika" class="login_input" name="slika"><br>
				</div>

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