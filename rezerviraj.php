<?php
require_once 'connect.php';
session_start();

$id = $_SESSION['id'];
$sql = "SELECT * FROM uporabniki WHERE id = ?;";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "s", $id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$query = mysqli_num_rows($result);

// modify the if statement to check if id exists in database
if ($query > 0) {
    $zival = $_GET['zival_id'];
    $sql = "SELECT * FROM rezervacija WHERE id = ?;";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $zival);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $query = mysqli_num_rows($result);
    if ($query == 0) {
        $id = $_SESSION['id'];
        $date = strtotime("+7 day");
        $datum = date('Y-m-d', $date);

        $sql = "INSERT INTO rezervacija (datum, uporabnik_id, zival_id) VALUES (?, ?, ?);";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "sss", $datum, $id, $zival);
        if (mysqli_stmt_execute($stmt)) {
            // get the ID of the newly created reservation
            $rezervacija_id = mysqli_insert_id($conn);

            // update the zivali table with the new reservation ID
            $update_sql = "UPDATE zivali SET rezervacija_id = ? WHERE id = ?;";
            $stmt = mysqli_prepare($conn, $update_sql);
            mysqli_stmt_bind_param($stmt, "ss", $rezervacija_id, $zival);
            if (mysqli_stmt_execute($stmt)) {
                setcookie('prijava', "Rezervacija uspešna.");
                setcookie('good', 1);
                header('Location: main.php');
            } else {
                setcookie('prijava', "Error: " . $update_sql . "<br>" . $conn->error);
                setcookie('error', 1);
                header('Location: main.php');
            }
        } else {
            setcookie('prijava', "Error: " . $sql . "<br>" . $conn->error);
            setcookie('error', 1);
            header('Location: main.php');
        }
    } else {
        setcookie('prijava', "Ta žival je že rezervirana za drugega uporabnika.");
        setcookie('warning', 1);
        header('Location: main.php');
    }
} else {
    setcookie('prijava', 'Niste prijavljeni.');
    setcookie('warning', 1);
    header('Location: index.php');
}
?>
