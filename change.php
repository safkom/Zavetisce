<?php
require_once 'connect.php';
require_once 'cookie.php';

$id = $_COOKIE['id'];
$sql = "SELECT * FROM uporabniki WHERE id = $id AND admin = 1;";
$result = mysqli_query($conn, $sql);
$query = mysqli_num_rows($result);

// Check if the user is an admin
if ($query > 0) {
    $zival = $_COOKIE['zival_id'];
    $uporabnikEmail = $_POST['uporabnikid'];

    // Get the uporabnik_id from the email
    $uporabnik_id = getUporabnikIdByEmail($conn, $uporabnikEmail);

    $ime = $_POST['ime'];
    $date = $_POST['datum'];
    $posvojen = isset($_POST['posvojen']) ? 1 : 0;

    // Update the zivali table
    $update_sql = "UPDATE zivali SET ime = '".$ime."', datum_r = '".$date."', posvojen = ".$posvojen." WHERE id = ".$zival.";";
    if ($conn->query($update_sql) === TRUE) {
        // Insert a new reservation
        $rezervacija_id = insertRezervacija($conn, $uporabnik_id, $zival);
        if ($rezervacija_id !== false) {
            // Update the rezervacija_id in the zivali table
            $update_sql2 = "UPDATE zivali SET rezervacija_id = ".$rezervacija_id." WHERE id = ".$zival.";";
            if ($conn->query($update_sql2) === TRUE) {
                // Handle file upload
                if (isset($_FILES['slika']) && $_FILES['slika']['error'] === UPLOAD_ERR_OK) {
                    $fileTmpPath = $_FILES['slika']['tmp_name'];
                    $fileName = $_FILES['slika']['name'];
                    $fileSize = $_FILES['slika']['size'];
                    $fileType = $_FILES['slika']['type'];
                    $fileNameCmps = explode(".", $fileName);
                    $fileExtension = strtolower(end($fileNameCmps));

                    $allowedfileExtensions = array('jpg', 'gif', 'png', 'zip', 'txt', 'xls', 'doc');
                    if (in_array($fileExtension, $allowedfileExtensions)) {
                        $uploadFileDir = './img/';
                        $newFileName = md5(time() . $fileName) . '.' . $fileExtension;
                        $dest_path = $uploadFileDir . $newFileName;

                        if (move_uploaded_file($fileTmpPath, $dest_path)) {
                            $slika_id = insertSlika($conn, $dest_path);
                            if ($slika_id !== false) {
                                // Update the slika_id in the zivali table
                                $update_sql3 = "UPDATE zivali SET slika_id = ".$slika_id." WHERE id = ".$zival.";";
                                if ($conn->query($update_sql3) === TRUE) {
                                    setcookie('prijava', "Sprememba uspešna.");
                                    header('Location: admin.php');
                                    exit();
                                } else {
                                    setcookie('prijava', "Error: " . $conn->error);
                                    header('Location: admin.php');
                                    exit();
                                }
                            } else {
                                setcookie('prijava', "Error: Failed to insert slika record.");
                                header('Location: admin.php');
                                exit();
                            }
                        } else {
                            setcookie('prijava', 'There was some error moving the file to upload directory. Please make sure the upload directory is writable by the web server.');
                            header('Location: admin.php');
                            exit();
                        }
                    } else {
                        setcookie('prijava', 'Upload failed. Allowed file types: ' . implode(',', $allowedfileExtensions));
                        header('Location: admin.php');
                        exit();
                    }
                } else {
                    setcookie('prijava', 'There is some error in the file upload. Please check the following error:'. $_FILES['slika']['error'].'Fix it.');
                    header('Location: admin.php');
                    exit();
                }
            } else {
                setcookie('prijava', "Error: " . $conn->error);
                header('Location: admin.php');
                exit();
            }
        } else {
            setcookie('prijava', "Error: Failed to insert rezervacija record.");
            header('Location: admin.php');
            exit();
        }
    } else {
        setcookie('prijava', "Error: " . $conn->error);
        header('Location: admin.php');
        exit();
    }
} else {
    setcookie('prijava', 'Only admins can perform this action.');
    header('Location: admin.php');
    exit();
}

// Function to get uporabnik_id by email
function getUporabnikIdByEmail($conn, $email) {
    $sql = "SELECT id FROM uporabniki WHERE email = '".$email."';";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($result);
    return $row['id'];
}

// Function to insert a new rezervacija record and return the inserted ID
function insertRezervacija($conn, $uporabnik_id, $zival_id) {
    $date = strtotime("+7 day");
    $datum = date('Y-m-d', $date);
    $insert_sql = "INSERT INTO rezervacija (datum, uporabnik_id, zival_id) VALUES ('".$datum."', ".$uporabnik_id.", ".$zival_id.")";
    if ($conn->query($insert_sql) === TRUE) {
        return mysqli_insert_id($conn);
    } else {
        return false;
    }
}

// Function to insert a new slika record and return the inserted ID
function insertSlika($conn, $url) {
    $slika_sql = "INSERT INTO slike (url) VALUES ('".$url."');";
    if ($conn->query($slika_sql) === TRUE) {
        return mysqli_insert_id($conn);
    } else {
        return false;
    }
}
