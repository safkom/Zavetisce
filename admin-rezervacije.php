<!DOCTYPE html>
<html lang="sl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Miha Šafranko"/>
	<meta name="author" content="Miha Šafranko" />
    <link rel="stylesheet" type="text/css" href="css/admin-rezervacije.css" />
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
    <div id = "container">
<?php
session_start();
require_once 'connect.php';
$id = $_SESSION['id'];
$sql = "SELECT * FROM uporabniki WHERE id = $id;";
$result = mysqli_query($conn,$sql);
$query = mysqli_num_rows($result);
// modify the if statement to check if id exists in database
    if($query != 0){
    if(isset($_COOKIE['prijava'])){
        echo $_COOKIE['prijava']."<br>";
    }
    setcookie('prijava', '');
    $sql = "SELECT * FROM zivali INNER JOIN rezervacija on zivali.id = rezervacija.zival_id;";
    $result = mysqli_query($conn,$sql);
    if(mysqli_num_rows($result) > 0){
    echo "Seznam kužkov:";
    echo '<table border ="1">';
    echo'<tr>';
        echo "<td><b>Ime</b></td><td><b>Starost</b></td><td><b>Posvojen</b></td><td><b>Slika</b></td><td><b>Rezerviran</b></td><td><b>Rezervacija - Uporabnik</b></td><td><b>Preklici rezervacijo</b></td>";
        echo'</tr>';

    while($row=mysqli_fetch_array($result)){
        $slikaid = $row['slika_id'];
        $sql = "SELECT * FROM slike WHERE id = ".$slikaid.";";
        $klic = mysqli_query($conn,$sql);
        $klic1 = mysqli_fetch_array($klic);
        $slika = $klic1['url'];
        $uporabnik_id = $row['uporabnik_id'];
        $zival_id = $row['zival_id'];
        $dateOfBirth = $row['datum_r'];
        $today = date("Y-m-d");
        $diff = date_diff(date_create($dateOfBirth), date_create($today));
        $ageInMonths = $diff->format('%m');
        $ageInYears = $diff->format('%y');
        if($ageInYears == 1){
            $leta = $ageInYears. ' leto in ';
        }
        if($ageInYears == 2){
            $leta = $ageInYears. ' leti in ';
        }
        if($ageInYears == 3){
            $leta = $ageInYears. ' leta in ';
        }
        if($ageInYears == 4){
            $leta = $ageInYears. ' leta in ';
        }
        if($ageInYears > 4){
            $leta = $ageInYears. ' let in ';
        }
        if($ageInMonths == 1){
            $age = $leta. '1 mesec';
        }
        if($ageInMonths == 2){
            $age = $leta. '2 mesca';
        }
        if($ageInMonths == 3){
            $age = $leta. '3 meseci';
        }
        if($ageInMonths == 4){
            $age = $leta . '4 meseci';
        }
        if($ageInMonths > 4){
            $age = $leta . $ageInMonths . ' mescov';
        }
        if($ageInMonths < 4){
            $age = 'Manj kot 1 mesec';
        }

        if($row['posvojen'] == 0){
            $posvojen = 'Ne';
        }
        else{
            $posvojen = 'Da';
        }
        if($row['uporabnik_id'] != null){
            $sql = "SELECT * from uporabniki WHERE id = ".$uporabnik_id.";";
            $result = mysqli_query($conn,$sql);
            $row=mysqli_fetch_array($result);
            $mail = $row['email'];
            $ime = $row['ime'];
            $rezerviran = "Da";
            $uporabnik = $ime. " - ". $mail;
        }
        else{
            $rezerviran = "Ne.";
            $uporabnik = "/";
        }

        echo'<tr>';
        echo '<td>'.$row['ime']."</td><td> ".$age. "</td><td> ".$posvojen."</td><td><img src='".$slika."'></td><td>".$rezerviran."</td><td>".$uporabnik."</td><td><a href = 'preklici.php?zival_id=".$zival_id."' >Preklici</td>";
        echo'</tr>';
    }
    echo '</table>';
 }
 else{
    setcookie('prijava', "V sistemu trenutno ni rezervacij.");
    setcookie('warning', 1);
    header('Location: admin.php');
}
}

?>
<br>
<div id="gumbi">
    <button class="gumbstyle" onclick="location.href = 'admin.php';">Nazaj</button>
    </div> 
</div>
</body>
</html>