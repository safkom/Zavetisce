<?php
require_once 'connect.php';
require_once 'cookie.php';

$id = $_GET['uporabnik_id'];

$sql = "DELETE FROM uporabniki WHERE id = $id;";
    if($conn->query($sql) === TRUE) {
        setcookie('prijava', "Izbris uspešen.");
        setcookie('good', 1);
        header('Location: uporabniki.php');
    } else {
        setcookie('prijava', "Error: " . $sql . "<br>" . $conn->error);
        setcookie('error', 1);
        header('Location: uporabniki.php');
    }
?>