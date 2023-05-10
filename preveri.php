<?php
require_once 'connect.php';

$email = $_GET['email'];
$password = $_GET['geslo'];

$sql = "SELECT * FROM uporabniki WHERE email = '$email';";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_array($result);
    $hash = $row['geslo'];
    if (password_verify($password, $hash)) {
        if($row['admin'] == 1){
            setcookie('id', $row['id']);
            setcookie('prijava', "Prijava uspešna.");
            header('Location: admin.php');
            exit();
        }
        setcookie('id', $row['id']);
        setcookie('prijava', "Prijava uspešna.");
        header('Location: main.php');
    } 
    else {
        setcookie('prijava', "Napačno geslo.");
        header('Location: index.php');
    }
} 
else {
    setcookie('prijava', "Uporabnik z tem mailom ne obstaja.");
    header('Location: index.php');
}

?>