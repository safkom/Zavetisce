<!DOCTYPE html>
<html lang="sl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Miha Šafranko">
    <meta name="author" content="Miha Šafranko">
    <link rel="stylesheet" type="text/css" href="css/main.css">
    <title>Sponzorstva</title>
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
    #gumbi {
        display: flex;
        justify-content: space-between;
    }
    .gumbstyle{
        background: #3498db;
  background-image: -webkit-linear-gradient(top, #3498db, #2980b9);
  background-image: -moz-linear-gradient(top, #3498db, #2980b9);
  background-image: -ms-linear-gradient(top, #3498db, #2980b9);
  background-image: -o-linear-gradient(top, #3498db, #2980b9);
  background-image: linear-gradient(to bottom, #3498db, #2980b9);
  -webkit-border-radius: 28;
  -moz-border-radius: 28;
  border-radius: 28px;
  font-family: Arial;
  color: #ffffff;
  font-size: 20px;
  padding: 10px 20px 10px 20px;
  text-decoration: none;
    }
    .gumbstyle:hover {
        background: #3cb0fd;
  background-image: -webkit-linear-gradient(top, #3cb0fd, #3498db);
  background-image: -moz-linear-gradient(top, #3cb0fd, #3498db);
  background-image: -ms-linear-gradient(top, #3cb0fd, #3498db);
  background-image: -o-linear-gradient(top, #3cb0fd, #3498db);
  background-image: linear-gradient(to bottom, #3cb0fd, #3498db);
  text-decoration: none;
    }
    </style>    
</head>

<body>

<div class="container">
<?php
require_once 'cookie.php';
require_once 'connect.php';
$sql = "SELECT * FROM sponzorstva s INNER JOIN zivali z ON s.id = z.sponzorstvo_id WHERE s.uporabnik_id = ".$_COOKIE['id'].";";
$result = mysqli_query($conn, $sql);
$query = mysqli_num_rows($result);
if($query > 0){
    echo "<p>Tukaj so živali, ki jih sponzoriraš:</p>";
echo "<table border='1'>";
echo "<tr>";
echo "<td><b>Ime</b></td>";
echo "<td><b>Starost</b></td>";
echo "<td><b>Slika</b></td>";
echo "<td><b>Prekliči sponzorstvo</b></td>";
echo "</tr>";

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
    } elseif ($ageInMonths == 0 && $ageInYears == 0) {
        $age = 'Manj kot 1 mesec.';
    } else {
        $age = '';
    }

    echo '<tr>';
    echo '<td>'.$row['ime']."</td><td>".$age."</td><td>";

    if (!empty($slika)) {
        echo "<img src='".$slika."'>";
    } else {
        echo "Ni slike";
    }
    
    $sponzorstvo = ""; // Initialize the $sponzorstvo variable
    
    if (!is_null($row['sponzorstvo_id'])) {
        $sponzorstvo = "<a href='preklicis.php?zival_id=".$row['s.id']."'>Prekliči</a>";
    }

    echo "</td><td>".$sponzorstvo."</td>";
    echo '</tr>';
}

echo "</table>";
echo "</div>";

        }
        ?>

<div class="container">
<div class="dropdown">
    <button id="menuBtn" class="menu-btn">Menu</button>
    <div id="menuContent" class="menu-content">
        <a href="rezervacije.php">Rezervacije</a>
        <a href="odjava.php">Odjava</a>
    </div>
</div>

<?php

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

$sql = "SELECT * FROM z zivali INNER JOIN sponzorstva s ON s.id = z.sponzorstvo_id;";
$result = mysqli_query($conn, $sql);
?>
    <p>Bi sponzoriral žival? Na tem seznamu lahko izbereš žival za sponzorirati:</p>
    <table border="1">
        <tr>
            <td><b>Ime</b></td>
            <td><b>Starost</b></td>
            <td><b>Slika</b></td>
            <td><b>Sponzoriraj</b></td>
        </tr>
        <?php
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
            } elseif ($ageInMonths == 0 && $ageInYears == 0) {
                $age = 'Manj kot 1 mesec.';
            } else {
                $age = '';
            }

            echo '<tr>';
            echo '<td>'.$row['ime']."</td><td>".$age."</td><td>";

            if (!empty($slika)) {
                echo "<img src='".$slika."'>";
            } else {
                echo "Ni slike";
            }
            if (is_null($row['sponzorstvo_id'])) {
                $sponzorstvo = "<a href='sponzoriraj.php?sponzorstvo_id=".$row['s.id']."'>Sponzoriraj</a>";
            } else {
                $sponzorstvo = 'Sponzorstvo je že urejeno.';
            }

            echo "</td><td>".$sponzorstvo."</td>";
            echo '</tr>';
        }
        ?>
    </table>
    <br>
    <div id="gumbi">
    <button class="gumbstyle" onclick="location.href = 'main.php';">Nazaj</button>
    </div>  
</div>

<div id="loginWindow">
    <?php
    if (isset($_COOKIE['prijava'])) {
        echo "✅ ";
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
