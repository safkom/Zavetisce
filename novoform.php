<!DOCTYPE html>
<html lang="sl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Miha Šafranko"/>
    <meta name="author" content="Miha Šafranko" />
    <link rel="stylesheet" href="css/login.css">
    <title>Nova žival</title>
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
    $danes = $date = date('m-d-Y');
    ?>
    <div class="container">
        <h1>Nov vnos</h1>
        <form class="login" id="spremembe" action="novo.php" method="post" enctype="multipart/form-data">
            <label for="ime">Ime:</label>
            <input type="text" id="ime" name="ime"  required><br><br>

            <label for="datum">Datum rojstva:</label>
            <input type="date" id="datum" name="datum" class="login_input" min = <?php echo $danes; ?> required><br><br>

            <label for="posvojen">Posvojen:</label>
            <input type="checkbox" id="posvojen" name="posvojen" class="login_input"><br><br>

            <label for="slika">Slika:</label>
            <input type="file" id="slika" class="login_input" name="slika"><br><br>

            <br>
            <input type="submit" value="Pošlji">
        </form>
        <form class="delete" id ="delete" action="admin.php" method="post" enctype="multipart/form-data">
        <input type="submit" value="Nazaj" style = "width: 100%;
  padding: 10px;
  background-color: red;
  color: #fff;
  border: none;
  border-radius: 4px;
  cursor: pointer;">
    </div>
</body>
</html>
