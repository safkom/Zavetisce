<?php
require_once 'connect.php';
require_once 'cookie.php';
    $id = $_COOKIE['id'];
    $zival = $_GET['zival_id'];
    echo $id;
    echo "<br>";
    echo $zival;
    $sql = "DELETE FROM rezervacija WHERE uporabnik_id = ".$id." AND zival_id = ".$zival.";";
    if($conn->query($sql) === TRUE) {
        setcookie('prijava', "Preklic uspešna.");
        header('Location: main.php');
    }
    else{
        setcookie('prijava', "Error: " . $sql . "<br>" . $conn->error);
        header('Location: main.php');
    }
?>