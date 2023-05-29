<!DOCTYPE html>
<html lang="sl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Miha Šafranko">
    <meta name="author" content="Miha Šafranko">
    <link rel="stylesheet" type="text/css" href="css/admin.css">
    <title>Zavetišče</title>
    <style>
        body{
            background: linear-gradient(90deg, #C7C5F4, #776BCC);
        }
        #container {
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px; /* Adding rounded corners */
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.2); /* Increasing the box shadow */
        }

        .dropdown {
        position: relative;
        display: inline-block;
    }

    .menu-btn {
        position: fixed;
        top: 20px;
        right: 20px;
        background-color: blue;
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
        <a href="admin-rezervacije.php">Rezervacije</a>
        <a href="odjava.php">Odjava</a>
    </div>
</div>

<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once 'cookie.php';
require_once 'connect.php';
if (!isset($_COOKIE['id'])) {
    header('Location: index.php');
    exit();
}
$id = $_COOKIE['id'];
$sql = "SELECT * FROM uporabniki WHERE id = $id AND admin = 1;";
$result = mysqli_query($conn, $sql);
$query = mysqli_num_rows($result);
// modify the if statement to check if id exists in the database
if ($query == 0) {
    header('Location: index.php');
    exit();
}
$sql = "SELECT * FROM zivali;";
$result = mysqli_query($conn, $sql);

?>
Seznam kužkov:
<table border="1">
    <tr>
        <td><b>Ime</b></td>
        <td><b>Starost</b></td>
        <td><b>Posvojen</b></td>
        <td><b>Slika</b></td>
        <td><b>Rezerviran</b></td>
        <td><b>Spremeni</b></td>
    </tr>

    <?php
    while ($row = mysqli_fetch_array($result)) {
        $zival_id = $row['id'];
        $slikaid = $row['slika_id'];
        $sql = "SELECT * FROM slike WHERE id = '$slikaid';";
        $klic = mysqli_query($conn, $sql);
        $klic1 = mysqli_fetch_array($klic);
    if ($klic1 !== null) {
        $slika = $klic1['url'];
    } else {
        $slika = ''; // or any default value you prefer
    }

        $dateOfBirth = $row['datum_r'];
        $today = date("Y-m-d");
        $diff = date_diff(date_create($dateOfBirth), date_create($today));
        $ageInMonths = $diff->format('%m');
        $ageInYears = $diff->format('%y');
        $leta = '';

        if ($ageInYears == 1) {
            $leta = $ageInYears . ' leto in ';
        } elseif ($ageInYears >= 2 && $ageInYears <= 4) {
            $leta = $ageInYears . ' leti in ';
        } elseif ($ageInYears > 4) {
            $leta = $ageInYears . ' let in ';
        }

        if ($ageInMonths == 1) {
            $age = $leta . '1 mesec';
        } elseif ($ageInMonths > 1 && $ageInMonths < 5) {
            $age = $leta . $ageInMonths . ' meseci';
        } elseif ($ageInMonths >= 5) {
            $age = $leta . $ageInMonths . ' mesecev';
        } elseif($ageInMonths == 0 && $ageInYears == 0) {
            $age = 'Manj kot 1 mesec.';
        }
        else{
            $age = '';
        }

        if ($row['posvojen'] == 0) {
            $posvojen = 'Ne';
        } else {
            $posvojen = 'Da';
        }

        if (is_null($row['rezervacija_id'])) {
            $rezervacija = "Ni rezervirano";
        } else {
            $sql = "SELECT * FROM rezervacija WHERE zival_id = $zival_id";
            $klic2 = mysqli_query($conn, $sql);
            $klic3 = mysqli_fetch_array($klic2);
            $datum = $klic3['datum'];
            $rezervacija = 'Da, ' . $datum;
        }

        echo '<tr>';
        echo '<td>' . $row['ime'] . '</td>';
        echo '<td>' . $age . '</td>';
        echo '<td>' . $posvojen . '</td>';
        echo '<td><img src="' . $slika . '"></td>';
        echo '<td>' . $rezervacija . '</td>';
        echo '<td><a href="spremembe.php?zival_id=' . $zival_id . '">Spremeni</a></td>';
        echo '</tr>';
    }
    ?>
</table>

<div id="loginWindow">
    <?php
    if (isset($_COOKIE['prijava'])) {
        echo $_COOKIE['prijava'];
        // setcookie("prijava", "", time() - 3600);
    }
    ?>
</div>
<script>
    var menuBtn = document.getElementById("menuBtn");
    var menuContent = document.getElementById("menuContent");

    menuBtn.addEventListener("click", function() {
        menuContent.style.display = (menuContent.style.display === "block") ? "none" : "block";
    });

    window.addEventListener("click", function(event) {
        if (!event.target.matches("#menuBtn")) {
            if (menuContent.style.display === "block") {
                menuContent.style.display = "none";
            }
        }
    });
    // Check if the cookie 'prijava' exists
    function checkCookie() {
        var name = "prijava=";
        var decodedCookie = decodeURIComponent(document.cookie);
        var cookieArray = decodedCookie.split(';');

        for (var i = 0; i < cookieArray.length; i++) {
            var cookie = cookieArray[i];
            while (cookie.charAt(0) === ' ') {
                cookie = cookie.substring(1);
            }
            if (cookie.indexOf(name) === 0) {
                return true;
            }
        }
        return false;
    }

    // Show the login window if the cookie exists
    if (checkCookie()) {
        var loginWindow = document.getElementById("loginWindow");
        loginWindow.style.display = "block";
        setTimeout(function () {
            loginWindow.style.display = "none";
        }, 5000);
    }
    document.cookie = 'prijava=; Max-Age=0';
</script>
</body>
</html>
