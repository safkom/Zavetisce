<!DOCTYPE html>
<html lang="sl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Miha Šafranko">
    <meta name="author" content="Miha Šafranko">
    <link rel="stylesheet" type="text/css" href="css/main.css">
    <link rel="stylesheet" type="text/css" href="css/style.css">
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
.filter-button {
  padding: 10px 20px;
  background-color: #4CAF50;
  color: white;
  border: none;
  cursor: pointer;
  font-size: 16px;
}

.filter-button:hover {
  background-color: #45a049;
}

.filter-button:active {
  background-color: #3e8740;
}
    </style>
</head>
<body>
<div id="container">
<div class="dropdown">
    <button id="menuBtn" class="menu-btn">Menu</button>
    <div id="menuContent" class="menu-content">
        <a href="admin-rezervacije.php">Rezervacije</a>
        <a href="uporabniki.php">Uporabniki</a>
        <a href="odjava.php">Odjava</a>
    </div>
</div>

<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();
require_once 'connect.php';
if (!isset($_SESSION["id"])) {
    header('Location: index.php');
    exit();
}
$id = $_SESSION["id"];
$sql = "SELECT * FROM uporabniki WHERE id = '$id' AND admin = 1;";
$result = mysqli_query($conn, $sql);
$query = mysqli_num_rows($result);
// modify the if statement to check if id exists in the database
if ($query == 0) {
    header('Location: index.php');
    exit();
}
$sql = "SELECT * FROM uporabniki;";
$result = mysqli_query($conn, $sql);

?>
<p>Seznam uporabnikov:</p>
  <br>
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
						      <th>Priimek</th>
						      <th>Mail</th>
						      <th>Naslov</th>
							  <th>Kraj</th>
                <th>Admin</th>
                <th>Izbriši uporabnika</th>
						    </tr>
</thread>
    <?php
    while($row = mysqli_fetch_array($result)) {
        $kraj_id = $row['kraj_id'];
        $uporabnik = $row['id'];
        $sql1 = "SELECT * FROM kraji WHERE id = " . $kraj_id . ";";
        $result1 = mysqli_query($conn, $sql1);
        $row1 = mysqli_fetch_array($result1);
        $kraj = $row1['kraj'];

        if($row['admin'] == 1) {
            $admin = 'Da';
        } else {
            $admin = 'Ne';
        }

        echo '<tr class = "alert" role = "alert">';
        echo '<td>' . $row['ime'] . '</td>';
        echo '<td>' .  $row['priimek']  . '</td>';
        echo '<td>' .  $row['email']  . '</td>';
        echo '<td>'. $row['naslov'] .'</td>';
        echo '<td>' . $kraj . '</td>';
        echo '<td>' . $admin . '</td>';
        echo '<td><a href="uporabnikdelete.php?uporabnik_id=' . $uporabnik . '">Izbriši</a></td>';
        echo '</tr>';
    }
    ?>
</table>
<br>
    <div id="gumbi">
    <button class="gumbstyle" onclick="location.href = 'admin.php';">Nazaj</button>
    </div>
</div> 
<br>

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
<script>
var filterOptionsContainer = document.getElementById("filterOptionsContainer");
var filterNameInput = document.getElementById("filterName");
var sortAgeSelect = document.getElementById("sortAge");

function toggleFilterOptions() {
  if (filterOptionsContainer.style.display === "none") {
    filterOptionsContainer.style.display = "block";
    enableFilterInputs();
  } else {
    filterOptionsContainer.style.display = "none";
    disableFilterInputs();
    filterTable(); // Filter the table when hiding the filter options
  }
}

function enableFilterInputs() {
  filterNameInput.disabled = false;
  sortAgeSelect.disabled = false;
}

function disableFilterInputs() {
  filterNameInput.disabled = true;
  sortAgeSelect.disabled = true;
  filterNameInput.value = ""; // Clear filter name input
  sortAgeSelect.value = "default"; // Reset sort age select
}

function filterTable() {
  var filterNameValue = filterNameInput.value.toLowerCase();
  var sortAgeValue = sortAgeSelect.value;

  var rows = document.querySelectorAll("table tr");

  for (var i = 1; i < rows.length; i++) {
    var name = rows[i].getElementsByTagName("td")[0].textContent.toLowerCase();

    if (filterOptionsContainer.style.display === "none") {
      rows[i].style.display = ""; // Display all rows when filter options are hidden
    } else if (name.includes(filterNameValue)) {
      rows[i].style.display = "";
    } else {
      rows[i].style.display = "none";
    }
  }

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

  var table = document.querySelector("table");
  table.innerHTML = "";
  table.appendChild(rows[0]);

  sortedRows.forEach(function(row) {
    table.appendChild(row);
  });
}

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
