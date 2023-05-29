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
        <h1>Spremembe</h1>
        <form class="login" id="spremembe" action="change.php" method="post" enctype="multipart/form-data">
            <label for="ime">Ime:</label>
            <input type="text" id="ime" name="ime" value="<?php echo $row['ime'] ?>" required><br><br>

            <label for="datum">Datum rojstva:</label>
            <input type="date" id="datum" name="datum" class="login_input" value="<?php echo $row['datum_r'] ?>" required><br><br>

            <label for="posvojen">Posvojen:</label>
            <input type="checkbox" id="posvojen" name="posvojen" class="login_input" <?php if($row['posvojen'] == 1){echo "checked";} ?>><br><br>

            <label for="slika">Slika:</label>
            <input type="file" id="slika" class="login_input" name="slika"><br><br>

            <label for="rezervacija">Rezervacija:</label>
            <input type="datalist" id="uporabnikid" class="login_input" name="uporabnikid"
            value="<?php
                $sql = "SELECT * FROM rezervacija WHERE zival_id = ".$_GET['zival_id'].";";
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
                        $sql = "SELECT * FROM uporabniki WHERE id = ".$uporabnik_id.";";
                        $result2 = mysqli_query($conn, $sql); // Use a different variable for the second query result
                        while ($row = mysqli_fetch_array($result2)) { // Loop through the second result
                            echo $row['email'];
                        }
                    }
                }
            ?>" list="uporabniki"><br><br>

            <br>
            <datalist id="zivali">
                <?php
                require_once 'connect.php';
                $sql = "SELECT * FROM zivali";
                $result = mysqli_query($conn, $sql);
                while ($row = mysqli_fetch_array($result)) {
                    echo "<option value='".$row['ime']."'>";
                }
                ?>
            </datalist>

            <datalist id="uporabniki">
                <?php
                require_once 'connect.php';
                $sql = "SELECT * FROM uporabniki";
                $result = mysqli_query($conn, $sql);
                while ($row = mysqli_fetch_array($result)) {
                    echo "<option value='".$row['email']."'>";
                }
                ?>
            </datalist>
            <input type="submit" value="Pošlji">
        </form>
    </div>
</body>
</html>
