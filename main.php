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
    #loginWindow {
    position: fixed;
    bottom: 10px;
    right: 10px;
    width: 200px;
    min-height: 30px;
    background-color: lightgreen;
    display: none;
    padding: 10px;
    border-radius: 5px;
}
    #errorWindow {
  position: fixed;
  bottom: 10px;
  right: 10px;
  width: 200px;
  min-height: 30px;
  background-color: lightcoral;
  display: none;
  padding: 10px;
  border-radius: 5px;
}
#warningWindow {
  position: fixed;
  bottom: 10px;
  right: 10px;
  width: 200px;
  min-height: 30px;
  background-color: lightblue;
  display: none;
  padding: 10px;
  border-radius: 5px;
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
?>
    <p>Seznam kužkov:</p>
    <button onclick="toggleFilterOptions()">Filter</button>

  <div id="filterOptionsContainer" class="filter-options">
    <label for="filterName">Filter by Name:</label>
    <input type="text" id="filterName" oninput="filterTable()" placeholder="Search by name">

    <label for="sortAge">Sort by Age:</label>
    <select id="sortAge" onchange="filterTable()">
      <option value="">-- Select sorting order --</option>
      <option value="asc">Ascending</option>
      <option value="desc">Descending</option>
    </select>
  </div>
    <table border="1">
        <tr>
            <td><b>Ime</b></td>
            <td><b>Starost</b></td>
            <td><b>Posvojen</b></td>
            <td><b>Slika</b></td>
            <td><b>Rezerviraj za ogled</b></td>
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
        ?>
    </table>
    <br>
    <div id="gumbi">
    <button class="gumbstyle" onclick="location.href = 'sponzorstva.php';">Sponzorstva</button>
    <button class="gumbstyle" onclick="location.href = 'sprehajanje.php';">Sprehajanje psov</button>
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
<div id="errorWindow">
    <?php
    if (isset($_COOKIE['prijava'])) {
        echo "⛔ ";
        echo $_COOKIE['prijava'];
        // setcookie("prijava", "", time() - 3600);
    }
    ?>
</div>
<div id="warningWindow">
    <?php
    if (isset($_COOKIE['prijava'])) {
        echo "⚠️ ";
        echo $_COOKIE['prijava'];
        // setcookie("prijava", "", time() - 3600);
    }
    ?>
</div>


<script>

var filterOptionsContainer = document.getElementById("filterOptionsContainer");

function toggleFilterOptions() {
      if (filterOptionsContainer.style.display === "none") {
        filterOptionsContainer.style.display = "block";
      } else {
        filterOptionsContainer.style.display = "none";
      }
    }
    
function filterTable() {
        // Get filter input values and convert them to lowercase
        var filterNameValue = document.getElementById("filterName").value.toLowerCase();
        var sortAgeValue = document.getElementById("sortAge").value;

        // Get all table rows
        var rows = document.querySelectorAll("table tr");

        // Loop through rows and hide those that don't match the filter
        for (var i = 1; i < rows.length; i++) {
          var name = rows[i].getElementsByTagName("td")[0].textContent.toLowerCase();

          if (name.includes(filterNameValue)) {
            rows[i].style.display = "";
          } else {
            rows[i].style.display = "none";
          }
        }

        // Sort table rows by age
        if (sortAgeValue === "asc") {
          var sortedRows = Array.from(rows).slice(1).sort(function(a, b) {
            var ageA = parseInt(a.getElementsByTagName("td")[1].textContent);
            var ageB = parseInt(b.getElementsByTagName("td")[1].textContent);
            return ageA - ageB;
          });
        } else if (sortAgeValue === "desc") {
          var sortedRows = Array.from(rows).slice(1).sort(function(a, b) {
            var ageA = parseInt(a.getElementsByTagName("td")[1].textContent);
            var ageB = parseInt(b.getElementsByTagName("td")[1].textContent);
            return ageB - ageA;
          });
        } else {
          var sortedRows = Array.from(rows).slice(1);
        }

        // Reorder table rows based on the sorted rows
        var table = document.querySelector("table");
        table.innerHTML = "";
        table.appendChild(rows[0]); // Keep the table header row at the top

        sortedRows.forEach(function(row) {
          table.appendChild(row);
        });
      }

      // Attach event listeners to the filter input fields
      document.getElementById("filterName").addEventListener("input", filterTable);
      document.getElementById("sortAge").addEventListener("change", filterTable);

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
    // Hide all the div elements initially
document.getElementById("errorWindow").style.display = "none";
document.getElementById("warningWindow").style.display = "none";
document.getElementById("loginWindow").style.display = "none";

// Check if cookie error is set to 1
if (getCookie("error") === "1") {
  document.getElementById("errorWindow").style.display = "block";
  setTimeout(function() {
    document.getElementById("errorWindow").style.display = "none";
  }, 5000); // Hide errorWindow after 5 seconds (adjust the time as needed)
}
// Check if cookie warning is set to 1
else if (getCookie("warning") === "1") {
  document.getElementById("warningWindow").style.display = "block";
  setTimeout(function() {
    document.getElementById("warningWindow").style.display = "none";
  }, 5000); // Hide warningWindow after 5 seconds (adjust the time as needed)
}
// If neither cookie is set to 1, show loginWindow
else if (getCookie("good") === "1"){
  document.getElementById("loginWindow").style.display = "block";
  setTimeout(function() {
    document.getElementById("loginWindow").style.display = "none";
  }, 5000); // Hide loginWindow after 5 seconds (adjust the time as needed)
}

// Function to get cookie value by name
function getCookie(name) {
  const cookies = document.cookie.split("; ");
  for (let i = 0; i < cookies.length; i++) {
    const cookie = cookies[i].split("=");
    if (cookie[0] === name) {
      return cookie[1];
    }
  }
  return "";
}

    document.cookie = 'prijava=; Max-Age=0';
    document.cookie = 'error=; Max-Age=0';
    document.cookie = 'warning=; Max-Age=0';
    document.cookie = 'good=; Max-Age=0';
</script>

</body>
</html>
