<?php
require_once 'connect.php';

$ime = $_GET['ime'];
$priimek = $_GET['priimek'];
$mail = $_GET['email'];
$geslo = $_GET['geslo'];
$naslov = $_GET['naslov'];
$kraj = $_GET['kraj'];

$sql = "INSERT INTO uporabniki (ime, priimek, email, geslo, naslov, kraj_id)
VALUES ('$ime', '$priimek', '$mail', '$geslo', '$naslov', (SELECT id from kraji WHERE kraj = '$kraj'));";

if ($conn->query($sql) === TRUE) {
    header('Location: razvrsti.php');
  } 
else {
    setcookie('register', "Error: " . $sql . "<br>" . $conn->error);
    header('Location: registracija.php');
  }
?>