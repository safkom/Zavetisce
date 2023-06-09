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
<?php
session_start();
require_once 'connect.php';

$sql = "SELECT * FROM zivali;";
$result = mysqli_query($conn, $sql);
?>
<div id = "container">
    <p>Seznam kužkov:</p>
    <div class="container">
        <div class="row justify-content-center">
        </div>
        <div class="row">
          <div class="col-md-12">
            <div class="table-wrap">
              <table class="table">
                <thead class="thead-dark">
                  <tr>
                    <th>Ime</th>
                    <th>Starost</th>
                    <th>Posvojen</th>
                    <th>Slika</th>
                  </tr>
  </thread>
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

            if ($row['posvojen'] == 0) {
                $posvojen = 'Ne';
            } else {
                $posvojen = 'Da';
            }

            echo '<tr class = "alert" role = "alert">';
            echo '<td>'.$row['ime']."</td><td>".$age."</td><td>".$posvojen."</td><td>";

            if (!empty($slika)) {
                echo "<img src='".$slika."'>";
            } else {
                echo "Ni slike";
            }
        }
        ?>
    </table>
    <br>
    <br>
    <div id="gumbi">
    <button class="gumbstyle" onclick="location.href = 'index.php';">Prijava</button>
</div>
</div>
</script>

</body>
</html>
