<!DOCTYPE html>
<html lang="sl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Miha Šafranko">
    <meta name="author" content="Miha Šafranko">
    <link rel="stylesheet" type="text/css" href="css/admin.css">
    <title>Zavetišče</title>
</head>
<body>
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

<a href="admin-rezervacije.php">Rezervacije</a><br>
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
        $slika = $klic1['url'];

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
        } elseif ($ageInMonths >= 2 && $ageInMonths <= 4) {
            $age = $leta . $ageInMonths . ' meseca';
        } elseif ($ageInMonths > 4) {
            $age = $leta . $ageInMonths . ' mesecev';
        } else {
            $age = $leta . $ageInMonths . ' mesec';
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
<a href="odjava.php">Odjava</a>
<script>
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
