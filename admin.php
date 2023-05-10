<!DOCTYPE html>
<html lang="sl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Miha Šafranko"/>
	<meta name="author" content="Miha Šafranko" />
    <link rel="stylesheet" type="text/css" href="stil.css" />
    <title>Zavetišče</title>
</head>
<body>
<?php
require_once 'cookie.php';
require_once 'connect.php';
if(!isset($_COOKIE['id'])){
    header('Location: index.php');
    exit();
}
$id = $_COOKIE['id'];
$sql = "SELECT * FROM uporabniki WHERE id = $id AND admin = 1;";
$result = mysqli_query($conn,$sql);
$query = mysqli_num_rows($result);
// modify the if statement to check if id exists in database
if($query == 0){
    header('Location: index.php');
    exit();
}
echo $_COOKIE['prijava']."<br>";
setcookie('prijava', '');
$sql = "SELECT * FROM zivali;";
$result = mysqli_query($conn,$sql);
echo "<a href='admin-rezervacije.php'>Rezervacije</a><br>";
echo "Seznam kužkov:";
    echo '<table border ="1">';
    echo'<tr>';
        echo "<td><b>Ime</b></td><td><b>Starost</b></td><td><b>Posvojen</b></td><td><b>Slika</b></td><td><b>Rezerviran</b></td>";
        echo'</tr>';

    while($row=mysqli_fetch_array($result)){
        $zival_id = $row['id'];
        $slikaid = $row['slika_id'];
        $sql = "SELECT * FROM slike WHERE id = ".$slikaid.";";
        $klic = mysqli_query($conn,$sql);
        $klic1 = mysqli_fetch_array($klic);
        $slika = $klic1['url'];

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

        if($row['posvojen'] == 0){
            $posvojen = 'Ne';
        }
        else{
            $posvojen = 'Da';
        }

        if(is_null($row['rezervacija_id'])){
            $rezervacija = "Ni rezervirano";
        }
        else{
            $sql = "SELECT * FROM rezervacija WHERE zival_id = '".$zival_id."'";
            $klic2 = mysqli_query($conn,$sql);
            $klic3 = mysqli_fetch_array($kli2);
            $datum = $klic3['datum'];
            $rezervacija = 'Da, ' + $datum;
        }

        echo'<tr>';
        echo '<td>'.$row['ime']."</td><td> ".$age. "</td><td> ".$posvojen."</td><td><img src='".$slika."'></td><td>".$rezervacija."</td>";
        echo'</tr>';
    }
    echo '</table>';

?>
<a href = "odjava.php">Odjava</a>
</body>
</html>