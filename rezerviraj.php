<?php
require_once 'connect.php';
require_once 'cookie.php';

$id = $_COOKIE['id'];
$sql = "SELECT * FROM uporabniki WHERE id = $id;";
$result = mysqli_query($conn, $sql);
$query = mysqli_num_rows($result);

// modify the if statement to check if id exists in database
if ($query > 0) {
    $id = $_COOKIE['id'];
    $zival = $_GET['zival_id'];
    $date = strtotime("+7 day");
    $datum = date('Y-m-d', $date);
    
    $sql = "INSERT INTO rezervacija (datum, uporabnik_id, zival_id)
    VALUES ('".$datum."', ".$id.", ".$zival.");";
    
    if ($conn->query($sql) === TRUE) {
        // get the ID of the newly created reservation
        $rezervacija_id = mysqli_insert_id($conn);
        
        // update the zivali table with the new reservation ID
        $update_sql = "UPDATE zivali SET rezervacija_id = ".$rezervacija_id." WHERE id = ".$zival.";";
        if ($conn->query($update_sql) === TRUE) {
            setcookie('prijava', "Rezervacija uspešna.");
            header('Location: main.php');
        } else {
            setcookie('prijava', "Error: " . $update_sql . "<br>" . $conn->error);
            header('Location: main.php');
        }
    } else {
        setcookie('prijava', "Error: " . $sql . "<br>" . $conn->error);
        header('Location: main.php');
    }
} else {
    header('Location: index.php');
}
?>
