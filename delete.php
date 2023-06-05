<?php
require_once 'connect.php';
require_once 'cookie.php';

$id = $_COOKIE['zival_id'];

$sql = "DELETE FROM zivali WHERE id = $id;";
    if($conn->query($sql) === TRUE) {
        setcookie('prijava', "Izbris uspešen.");
        header('Location: admin.php');
    } else {
        setcookie('prijava', "Error: " . $sql . "<br>" . $conn->error);
        setcookie('error', 1);
        header('Location: admin.php');
    }
?>