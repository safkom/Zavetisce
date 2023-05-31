<!DOCTYPE html>
<html lang="sl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Miha Šafranko"/>
    <meta name="author" content="Miha Šafranko" />
    <link rel="stylesheet" href="css/login.css">
    <title>Spremembe</title>
    <style>
        body{
            background: linear-gradient(90deg, #C7C5F4, #776BCC);
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
  .container input[type="date"],
  .container input[type="file"],
  .container input[type="datalist"],
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
}/* Responsive Styles */
@media (max-width: 600px) {
    .container {
      max-width: 100%;
      margin: 20px;
      box-shadow: none;
    }
  }
        </style>
</head>
<body>
    <?php
    require_once 'cookie.php';
    require_once 'connect.php';
    $zival = $_GET['zival_id'];
    setcookie('zival_id', $zival);
    $sql = "SELECT * FROM zivali WHERE id = ".$_GET['zival_id'].";";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($result);
    ?>
    <div class="container">
        <h1>Sponzorstvo</h1>
        <p>Tukaj uredi vse podatke, da sponzoriraš žival</p>
        <form class="login" id="spremembe" action="sponsor.php" method="post" enctype="multipart/form-data">
            <label for="ime">Ime živali:</label>
            <input type="text" id="ime" name="ime" value="<?php echo $row['ime'] ?>" readonly><br><br>

            <label for="datum">Datum začetka:</label>
            <input type="date" id="datum" name="datum" class="login_input" required><br><br>

            <label for="cas">Čas sponzorstva:</label>
            <input type="date" id="cas" name="cas" class="login_input" required><br><br>
            <p>Vrsta sponzorstva:</p>
            <p>Splošna oskrba:
            <input type="radio" id="oskrba" name="sponzorstvo" value="Splošna oskrba"></p>
            <p>Zdravljenje:
            <input type="radio" id="zdravljenje" name="sponzorstvo" value="Zdravljenje"></p>
            <p>Prehrana:
            <input type="radio" id="prehrana" name="sponzorstvoa" value="Prehrana"></p>
            

           <br><br>
            <input type="submit" value="Pošlji">
        </form>
        <form class="delete" id ="delete" action="sponzorstva.php" method="post" enctype="multipart/form-data">
        <input type="submit" value="Prekliči" style = "width: 100%;
  padding: 10px;
  background-color: red;
  color: #fff;
  border: none;
  border-radius: 4px;
  cursor: pointer;">
    </div>
</body>
</html>
