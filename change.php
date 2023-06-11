<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once 'connect.php';
session_start();

$id = $_SESSION["id"];
$sql = "SELECT * FROM uporabniki WHERE id = $id AND admin = 1;";
$result = mysqli_query($conn, $sql);
$query = mysqli_num_rows($result);

// Check if the user is an admin
if ($query > 0) {
    $zival = $_SESSION["zival_id"];
    $uporabnikEmail = $_POST['uporabnikid'];

    // Check if uporabnikId is empty
    if (!empty($uporabnikEmail)) {
        // Get the uporabnik_id from the email
        $uporabnik_id = getUporabnikIdByEmail($conn, $uporabnikEmail);

        $ime = $_POST['ime'];
        $date = $_POST['datum'];
        $posvojen = isset($_POST['posvojen']) ? 1 : 0;

        // Update the zivali table
        $update_sql = "UPDATE zivali SET ime = ?, datum_r = ?, posvojen = ? WHERE id = ?";
        $stmt = $conn->prepare($update_sql);
        $stmt->bind_param('ssii', $ime, $date, $posvojen, $zival);
        if ($stmt->execute()) {
            // Delete the previous reservation
            $delete_sql = "DELETE FROM rezervacija WHERE zival_id = ?";
            $stmt2 = $conn->prepare($delete_sql);
            $stmt2->bind_param('i', $zival);
            if ($stmt2->execute()) {
                // Insert a new reservation
                $rezervacija_id = insertRezervacija($conn, $uporabnik_id, $zival);
                if ($rezervacija_id !== false) {
                    // Update the rezervacija_id in the zivali table
                    $update_sql2 = "UPDATE zivali SET rezervacija_id = ? WHERE id = ?";
                    $stmt3 = $conn->prepare($update_sql2);
                    $stmt3->bind_param('ii', $rezervacija_id, $zival);
                    if ($stmt3->execute()) {
                        // Handle file upload
                        if (isset($_FILES['slika']) && $_FILES['slika']['error'] === UPLOAD_ERR_OK) {
                            $fileTmpPath = $_FILES['slika']['tmp_name'];
                            $fileName = $_FILES['slika']['name'];
                            $fileSize = $_FILES['slika']['size'];
                            $fileType = $_FILES['slika']['type'];
                            $fileNameCmps = explode(".", $fileName);
                            $fileExtension = strtolower(end($fileNameCmps));

                            $allowedfileExtensions = array('jpg', 'gif', 'png');
                            if (in_array($fileExtension, $allowedfileExtensions)) {
                                $uploadFileDir = 'img/';
                                $newFileName = md5(time() . $fileName) . '.' . $fileExtension;
                                $dest_path = $uploadFileDir . $newFileName;

                                if (move_uploaded_file($fileTmpPath, $dest_path)) {
                                    $slika_id = insertSlika($conn, $dest_path);
                                    if ($slika_id !== false) {
                                        // Update the slika_id in the zivali table
                                        $update_sql3 = "UPDATE zivali SET slika_id = ? WHERE id = ?";
                                        $stmt4 = $conn->prepare($update_sql3);
                                        $stmt4->bind_param('ii', $slika_id, $zival);
                                        if ($stmt4->execute()) {
                                            setcookie('prijava', "Sprememba uspešna.");
                                            setcookie('good', 1);
                                            header('Location: admin.php');
                                            exit();
                                        } else {
                                            setcookie('prijava', "Error: " . $conn->error);
                                            setcookie('error', 1);
                                            header('Location: admin.php');
                                            exit();
                                        }
                                    } else {
                                        setcookie('prijava', "Error: Failed to insert slika record.");
                                        setcookie('error', 1);
                                        header('Location: admin.php');
                                        exit();
                                    }
                                } else {
                                    setcookie('prijava', 'There was some error moving the file to upload directory. Please make sure the upload directory is writable by the web server.');
                                    setcookie('error', 1);
                                    header('Location: admin.php');
                                    exit();
                                }
                            } else {
                                setcookie('prijava', 'Upload failed. Allowed file types: ' . implode(',', $allowedfileExtensions));
                                setcookie('error', 1);
                                header('Location: admin.php');
                                exit();
                            }
                        } else {
                            setcookie('prijava', 'Sprememba uspešna.');
                            setcookie('good', 1);
                            header('Location: admin.php');
                            exit();
                        }
                    } else {
                        setcookie('prijava', "Error: " . $conn->error);
                        setcookie('error', 1);
                        header('Location: admin.php');
                        exit();
                    }
                } else {
                    setcookie('prijava', "Error: Failed to insert rezervacija record.");
                    setcookie('error', 1);
                    header('Location: admin.php');
                    exit();
                }
            } else {
                setcookie('prijava', "Error: " . $conn->error);
                setcookie('error', 1);
                header('Location: admin.php');
                exit();
            }
        } else {
            setcookie('prijava', "Error: " . $conn->error);
            setcookie('error', 1);
            header('Location: admin.php');
            exit();
        }
    } else {
        setcookie('prijava', 'Sprememba uspešna.');
        setcookie('good', 1);
        header('Location: admin.php');
        exit();
    }
} else {
    setcookie('prijava', 'Only admins can perform this action.');
    setcookie('error', 1);
    header('Location: main.php');
    exit();
}

// Function to get uporabnik_id by email
function getUporabnikIdByEmail($conn, $email) {
    $sql = "SELECT id FROM uporabniki WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    return $row['id'];
}

// Function to insert a new rezervacija record and return the inserted ID
function insertRezervacija($conn, $uporabnik_id, $zival_id) {
    $date = strtotime("+7 day");
    $datum = date('Y-m-d', $date);
    $insert_sql = "INSERT INTO rezervacija (datum, uporabnik_id, zival_id) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($insert_sql);
    $stmt->bind_param('sii', $datum, $uporabnik_id, $zival_id);
    if ($stmt->execute()) {
        return $stmt->insert_id;
    } else {
        return false;
    }
}

// Function to insert a new slika record and return the inserted ID
function insertSlika($conn, $url) {
    $slika_sql = "INSERT INTO slike (url) VALUES (?)";
    $stmt = $conn->prepare($slika_sql);
    $stmt->bind_param('s', $url);
    if ($stmt->execute()) {
        return $stmt->insert_id;
    } else {
        return false;
    }
}
?>
