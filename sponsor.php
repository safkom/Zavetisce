<?php
require_once 'connect.php';
require_once 'cookie.php';

$datum_z = $_POST['datum'];
$cas = $_POST['cas'];
$vrsta = $_POST['sponzorstvo'];
$uporabnik_id = $_COOKIE['id'];
$zival_id = $_COOKIE['zival_id'];

// Prepare the INSERT statement
$sql = "INSERT INTO sponzorstva (uporabnik_id, vrsta, datum_zacetka, datum_konca)
    VALUES (?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssss", $uporabnik_id, $vrsta, $datum_z, $cas);
if ($stmt->execute()) {
    $sponzorstvo_id = $stmt->insert_id; // Get the ID of the newly created sponzorstvo

    // Update the zivali table
    $update_sql = "UPDATE zivali SET sponzorstvo_id = ? WHERE id = ?";
    $update_stmt = $conn->prepare($update_sql);
    $update_stmt->bind_param("ss", $sponzorstvo_id, $zival_id);
    if ($update_stmt->execute()) {
        setcookie('prijava', "Sponzorstvo urejeno.");
        header('Location: main.php');
    } else {
        setcookie('prijava', "Error updating zivali: " . $update_stmt->error);
        header('Location: main.php');
    }
} else {
    setcookie('register', "Error creating sponzorstvo: " . $stmt->error);
    header('Location: main.php');
}

$stmt->close();
$update_stmt->close();
$conn->close();
?>