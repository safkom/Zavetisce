<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once 'connect.php';
require_once 'cookie.php';

$ime = $_POST['ime'];
$date = $_POST['datum'];
$posvojen = isset($_POST['posvojen']) ? 1 : 0;

echo $ime, $date, $posvojen;

// Update the zivali table
$insert_sql = "INSERT INTO zivali (ime, datum_r, posvojen) VALUES (?, ?, ?)";
$stmt = $conn->prepare($insert_sql);
$stmt->bind_param('ssi', $ime, $date, $posvojen);

if ($stmt->execute()) {
    $zival_id = $stmt->insert_id;
    echo "Vnos uspešen!";

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
                    $stmt4->bind_param('ii', $slika_id, $zival_id);
                    if ($stmt4->execute()) {
                        setcookie('prijava', 'Vnos uspešen.');
                        setcookie('good', 1);
                        header('Location: admin.php');
                    } else {
                        setcookie("prijava", "Vnos ni uspel");
                        setcookie('error', 1);
                        header('Location: admin.php');
                    }
                } else {
                    setcookie("prijava", "Vnos ni uspel");
                    setcookie('error', 1);
                    header('Location: admin.php');
                }
            } else {
                setcookie('prijava', 'There was some error moving the file to the upload directory. Please make sure the upload directory is writable by the web server.');
                setcookie('error', 1);
                header('Location: admin.php');
            }
        } else {
            setcookie('prijava', 'Upload failed. Allowed file types: ' . implode(',', $allowedfileExtensions));
            setcookie('error', 1);
            header('Location: admin.php');
        }
    } else {
        setcookie('prijava', 'Vnos brez slike uspešen.');
        setcookie('warning', 1);
        header('Location: admin.php');
    }
}

// Function to insert a new slika record and return the inserted ID
function insertSlika($conn, $url)
{
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
