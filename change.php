<?php
require_once 'connect.php';
require_once 'cookie.php';

$id = $_COOKIE['id'];
$sql = "SELECT * FROM uporabniki WHERE id = $id AND admin = 1;";
$result = mysqli_query($conn, $sql);
$query = mysqli_num_rows($result);

// modify the if statement to check if id exists in database
if ($query > 0) {
    $id = $_COOKIE['id'];
    $mail = $_GET['uporabnikid'];
    $sql = "SELECT * FROM uporabniki WHERE email = '".$mail."';";
    $result = mysqli_query($conn, $sql);
    $row=mysqli_fetch_array($result);
    $uporabnik_id = $row['id'];
    $zival = $_COOKIE['zival_id'];
    $date = strtotime("+7 day");
    $datum = date('Y-m-d', $date);
    $ime = $_GET['ime'];
    $date = $_GET['datum'];
    $posvojen = $_GET['posvojen'];
    
    $update_sql = "UPDATE zivali SET ime = '".$ime."', datum_r = '".$date."', posvojen = ".$posvojen."
    WHERE id = ".$zival.";";
    
    if ($conn->query($update_sql) === TRUE) {
        // get the ID of the newly created reservation
        $insert_sql = "INSERT INTO rezervacija (datum, uporabnik_id, zival_id)
        VALUES ('".$datum."', ".$uporabnik_id.", ".$zival.")";
        if ($conn->query($insert_sql) === TRUE) {
            $rezervacija_id = mysqli_insert_id($conn);
            $update_sql2 = "UPDATE zivali SET rezervacija_id = ".$rezervacija_id." WHERE id = ".$zival.";";
            if ($conn->query($update_sql2) === TRUE) {
                setcookie('prijava', "Sprememba uspešna.");
                header('Location: admin.php');
            } else {
                setcookie('prijava', "Error: " . $update_sql . "<br>" . $conn->error);
                header('Location: admin.php');
            }
        } else {
            setcookie('prijava', "Error: " . $update_sql . "<br>" . $conn->error);
            header('Location: admin.php');
        }
    } else {
        setcookie('prijava', "Error: " . $sql . "<br>" . $conn->error);
        header('Location: admin.php');
    }
} else {
    header('Location: index.php');
}
?>