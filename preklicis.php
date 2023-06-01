<?php
require_once 'connect.php';
require_once 'cookie.php';

$id = $_COOKIE['id'];
$zival = $_GET['zival_id'];
echo $id;
echo "<br>";
echo $zival;

if (isset($_COOKIE['admin'])) {
    $sql = "DELETE FROM sponzorstva WHERE zival_id = ?;";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $zival);
    if ($stmt->execute()) {
        setcookie('prijava', "Preklic uspešen.");
        header('Location: admin.php');
        exit(); // Add an exit() after redirecting to prevent further code execution
    } else {
        setcookie('prijava', "Error: " . $stmt->error);
        header('Location: admin.php');
        exit(); // Add an exit() after redirecting to prevent further code execution
    }
}

$sql = "DELETE FROM sponzorstva WHERE uporabnik_id = ? AND zival_id = ?;";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $id, $zival);
if ($stmt->execute()) {
    setcookie('prijava', "Preklic uspešen.");
    header('Location: main.php');
    exit(); // Add an exit() after redirecting to prevent further code execution
} else {
    setcookie('prijava', "Error: " . $stmt->error);
    header('Location: main.php');
    exit(); // Add an exit() after redirecting to prevent further code execution
}

$stmt->close();
$conn->close();
?>
