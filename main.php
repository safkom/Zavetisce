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
        body{
            background: linear-gradient(90deg, #C7C5F4, #776BCC);
        }
        .container {
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px; /* Adding rounded corners */
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.2); /* Increasing the box shadow */
        }
    </style>
</head>

<body>
    <div id = "container">
<?php
require_once 'cookie.php';
require_once 'connect.php';

if (!isset($_COOKIE['id'])) {
    header('Location: index.php');
    exit();
}

if (isset($_COOKIE['admin'])) {
    header('Location: admin.php');
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

echo "<a href='rezervacije.php'>Rezervacije</a><br>";
echo "Seznam kužkov:";
echo '<table border="1">';
echo '<tr>';
echo "<td><b>Ime</b></td><td><b>Starost</b></td><td><b>Posvojen</b></td><td><b>Slika</b></td><td><b>Rezerviraj</b></td>";
echo '</tr>';

while ($row = mysqli_fetch_array($result)) {
    $slikaid = $row['slika_id'];
    $sql1 = "SELECT * FROM slike WHERE id = '$slikaid';";
    $klic = mysqli_query($conn, $sql1);
    $klic1 = mysqli_fetch_array($klic);
    
    if ($klic1 !== null) {
        $slika = $klic1['url'];
    } else {
        $slika = null;
    }

    $dateOfBirth = $row['datum_r'];
    $today = date("Y-m-d");
    $diff = date_diff(date_create($dateOfBirth), date_create($today));
    $ageInMonths = $diff->format('%m');
    $ageInYears = $diff->format('%y');

    if ($ageInYears == 1) {
        $leta = $ageInYears . ' leto in ';
    } elseif ($ageInYears > 1 && $ageInYears < 5) {
        $leta = $ageInYears . ' leti in ';
    } elseif ($ageInYears >= 5) {
        $leta = $ageInYears . ' let in ';
    } else {
        $leta = '';
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
        $rezervacija = "<a href='rezerviraj.php?zival_id=".$row['id']."'>Rezerviraj</a>";
    } else {
        $rezervacija = 'Rezervirano';
    }

    echo '<tr>';
    echo '<td>'.$row['ime']."</td><td>".$age."</td><td>".$posvojen."</td><td>";
    
    if (!empty($slika)) {
        echo "<img src='".$slika."'>";
    } else {
        echo "Ni slike";
    }
    
    echo "</td><td>".$rezervacija."</td>";
    echo '</tr>';
}

echo "</div>";

?>
</div>

<div id="loginWindow" style="display: none;">
    <?php if(isset($_COOKIE['prijava']) && $_COOKIE['good'] == 1){
        echo htmlspecialchars($_COOKIE['prijava']);
        setcookie("prijava", "", time() - 3600);
    }?>
</div>
<div id="loginWindow2" style="display: none;">
    <?php if(isset($_COOKIE['prijava']) && $_COOKIE['good'] != 1){
        echo htmlspecialchars($_COOKIE['prijava']);
        setcookie("prijava", "", time() - 3600);
    }?>
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
            while (cookie.charAt(0) == ' ') {
                cookie = cookie.substring(1);
            }
            if (cookie.indexOf(name) == 0) {
                return true;
            }
        }
        return false;
    }

    // Show the appropriate login window based on the cookie value
    if (checkCookie()) {
        var loginWindow = document.getElementById("loginWindow");
        var loginWindow2 = document.getElementById("loginWindow2");
        
        if (document.cookie.indexOf("good=1") !== -1) {
            loginWindow.style.display = "block";
            setTimeout(function() {
                loginWindow.style.display = "none";
            }, 5000);
        } else {
            loginWindow2.style.display = "block";
            setTimeout(function() {
                loginWindow2.style.display = "none";
            }, 5000);
        }
    }
    
    document.cookie = 'prijava=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;';
</script>

</body>
</html>
