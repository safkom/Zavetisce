<!DOCTYPE html>
<html lang="sl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Miha Šafranko"/>
    <meta name="author" content="Miha Šafranko" />
    <link rel="stylesheet" type="text/css" href="css/rezervacije.css" />
    <style>
        body{
            background: linear-gradient(90deg, #C7C5F4, #776BCC);
        }
    </style>
    <title>Zavetišče</title>
</head>
<body>
<?php
require_once 'cookie.php';
require_once 'connect.php';

$id = $_COOKIE['id'];

// Check if ID exists in the database
$sql = "SELECT * FROM uporabniki WHERE id = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if (mysqli_num_rows($result) > 0) {
    if (isset($_COOKIE['prijava'])) {
        echo $_COOKIE['prijava'] . "<br>";
    }
    setcookie('prijava', '');

    // Fetch reserved animals
    $sql = "SELECT zivali.ime, zivali.datum_r, zivali.posvojen, zivali.slika_id, rezervacija.zival_id FROM zivali INNER JOIN rezervacija ON zivali.id = rezervacija.zival_id WHERE rezervacija.uporabnik_id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    echo "Seznam kužkov:";
    echo '<table border="1">';
    echo '<tr>';
    echo "<td><b>Ime</b></td><td><b>Starost</b></td><td><b>Posvojen</b></td><td><b>Slika</b></td><td><b>Preklici rezervacijo</b></td>";
    echo '</tr>';

    while ($row = mysqli_fetch_array($result)) {
        $slikaid = $row['slika_id'];
        $sql = "SELECT * FROM slike WHERE id = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "i", $slikaid);
        mysqli_stmt_execute($stmt);
        $klic = mysqli_stmt_get_result($stmt);
        $klic1 = mysqli_fetch_array($klic);
        $slika = $klic1['url'];

        $dateOfBirth = $row['datum_r'];
        $today = date("Y-m-d");
        $diff = date_diff(date_create($dateOfBirth), date_create($today));
        $ageInMonths = $diff->format('%m');
        $ageInYears = $diff->format('%y');

        if ($ageInYears == 1) {
            $leta = $ageInYears . ' leto in ';
        } elseif ($ageInYears == 2) {
            $leta = $ageInYears . ' leti in ';
        } elseif ($ageInYears == 3 || $ageInYears == 4) {
            $leta = $ageInYears . ' leta in ';
        } elseif ($ageInYears > 4) {
            $leta = $ageInYears . ' let in ';
        } else {
            $leta = '';
        }

        if ($ageInMonths == 1) {
            $age = $leta . '1 mesec';
        } elseif ($ageInMonths == 2) {
            $age = $leta . '2 mesca';
        } elseif ($ageInMonths == 3) {
            $age = $leta . '3 meseci';
        } elseif ($ageInMonths == 4) {
            $age = $leta . '4 meseci';
        } elseif ($ageInMonths > 4) {
            $age = $leta . $ageInMonths . ' mescov';
        } else {
            $age = "Mlajši od 1 meseca.";
        }

        $posvojen = ($row['posvojen'] == 0) ? 'Ne' : 'Da';

        echo '<tr>';
        echo '<td>' . $row['ime'] . "</td><td> " . $age . "</td><td> " . $posvojen . "</td><td><img src='" . $slika . "'></td><td><a href='preklici.php?zival_id=" . $row['zival_id'] . "'>Preklici</td>";
        echo '</tr>';
    }
    echo '</table>';
} else {
    header('Location: index.php');
    exit();
}
?>
<a href="main.php">Nazaj</a>
</body>
</html>
