<?php
require_once 'connect.php';
require_once 'cookie.php';

$id = $_SESSION['id'];
$zival = $_GET['zival_id'];
echo $id;
echo "<br>";
echo $zival;

if (isset($_SESSION['admin'])) {
    $sql = "DELETE FROM rezervacija WHERE zival_id = ?;";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $zival);
    if ($stmt->execute()) {
        setcookie('prijava', "Preklic uspešen.");
        setcookie('good', 1);
        header('Location: admin.php');
    } else {
        setcookie('prijava', "Error: " . $stmt->error);
        setcookie('error', 1);
        header('Location: admin.php');
    }
    exit();
}

$sql = "DELETE FROM rezervacija WHERE uporabnik_id = ? AND zival_id = ?;";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $id, $zival);
if ($stmt->execute()) {
    setcookie('prijava', "Preklic uspešen.");
    setcookie('good', 1);
    header('Location: main.php');
} else {
    setcookie('prijava', "Error: " . $stmt->error);
    setcookie('error', 1);
    header('Location: main.php');
}

$stmt->close();
$conn->close();
?>
