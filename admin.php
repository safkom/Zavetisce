<!DOCTYPE html>
<html lang="sl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Miha Šafranko">
    <meta name="author" content="Miha Šafranko">
    <link rel="stylesheet" type="text/css" href="css/main.css">
    <title>Zavetišče</title>
    <style>
        body {
            background: linear-gradient(90deg, #C7C5F4, #776BCC);
        }
        #container {
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.2);
        }
        .dropdown {
            position: relative;
            display: inline-block;
        }
        .menu-btn {
            position: fixed;
            top: 20px;
            right: 20px;
            background-color: #4CAF50;
            color: white;
            padding: 10px;
            font-size: 16px;
            border: none;
            cursor: pointer;
            border-radius: 4px;
        }
        .menu-content {
            display: none;
            position: fixed;
            top: 60px;
            right: 20px;
            background-color: #f9f9f9;
            min-width: 120px;
            box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
            z-index: 1;
        }
        .menu-content a {
            color: black;
            padding: 12px 16px;
            text-decoration: none;
            display: block;
        }
    </style>
</head>
<body>
<div id="container">
    <div class="dropdown">
        <button id="menuBtn" class="menu-btn">Menu</button>
        <div id="menuContent" class="menu-content">
            <a href="rezervacije.php">Rezervacije</a>
            <a href="odjava.php">Odjava</a>
        </div>
    </div>

    <?php
    require_once 'cookie.php';
    require_once 'connect.php';

    if (!isset($_COOKIE['id'])) {
        header('Location: index.php');
        exit();
    }

    if (!isset($_COOKIE['admin'])) {
        header('Location: main.php');
        exit();
    }

    $id = mysqli_real_escape_string($conn, $_COOKIE['id']);

    $sql = "SELECT * FROM uporabniki WHERE id = '$id';";
    $result = mysqli_query($conn, $sql);
    $query = mysqli_num_rows($result);

    // Modify the if statement to check if id exists in the database
    if ($query == 0) {
        header('Location: index.php');
        exit();
    }

    $sql = "SELECT * FROM zivali;";
    $result = mysqli_query($conn, $sql);
    ?>

    <p>Seznam kužkov:</p>
    <table border="1">
        <tr>
            <td><b>Ime</b></td>
            <td><b>Starost</b></td>
            <td><b>Posvojen</b></td>
            <td><b>Slika</b></td>
        </tr>
        <?php
        while ($row = mysqli_fetch_assoc($result)) {
            echo '<tr>';
            echo '<td>'.$row['ime'].'</td>';
            echo '<td>'.$row['starost'].'</td>';
            echo '<td>';
            if ($row['posvojen']) {
                echo 'Da';
            } else {
                echo 'Ne';
            }
            echo '</td>';
            echo '<td><img src="'.$row['slika'].'" width="100" height="100"></td>';
            echo '</tr>';
        }
        ?>
    </table>
</div>
<script>
    // Add JavaScript code here
    const menuBtn = document.getElementById('menuBtn');
    const menuContent = document.getElementById('menuContent');

    menuBtn.addEventListener('click', function() {
        if (menuContent.style.display === 'none') {
            menuContent.style.display = 'block';
        } else {
            menuContent.style.display = 'none';
        }
    });
</script>
</body>
</html>
