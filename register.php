<?php
require_once 'connect.php';
require_once 'cookie.php';

$ime = $_GET['ime'];
$priimek = $_GET['priimek'];
$mail = $_GET['email'];
$geslo1 = $_GET['geslo'];
$geslo = password_hash($geslo1, PASSWORD_DEFAULT);
$naslov = $_GET['naslov'];
$kraj = $_GET['kraj'];

$sql = "SELECT * FROM uporabniki WHERE email = '$mail';";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) == 0) {
    $sql = "INSERT INTO uporabniki (ime, priimek, email, geslo, naslov, kraj_id)
    VALUES ('$ime', '$priimek', '$mail', '$geslo', '$naslov', (SELECT id from kraji WHERE kraj = '$kraj'));";
    if ($conn->query($sql) === TRUE) {
        setcookie('prijava', "Registracija uspešna.");
        header('Location: preveri.php');
    } else {
        setcookie('register', "Error: " . $sql . "<br>" . $conn->error);
        header('Location: registracija.php');
    }
} else {
    setcookie('register', "Error: Uporabnik z tem mailom že obstaja.");
    header('Location: registracija.php');
}

?>