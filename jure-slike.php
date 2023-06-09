<?php
// sam zate dragi :)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once 'baza.php';
require_once 'cookie.php';

$ime = $_POST['ime'];
$opis = $_POST['opis'];
$datum = $_POST['datum'];
$tezavnost = $_POST['tezavnost'];
$kraj = $_POST['kraj'];
$lokacija = $_POST['lokacija'];
$uporabnik = $_SESSION['idu'];


$insert_sql = "INSERT INTO treningi (ime, opis, datum, tezavnost, lokacija_id, kraj_id, uporabnik_id) VALUES (?, ?, ?, ?, ?, ?, ?)";
$stmt = $link->prepare($insert_sql);
$stmt->bind_param('sssiiiii', $ime, $opis, $datum, $tezavnost, $lokacija, $kraj, $uporabnik);

if ($stmt->execute()) {
    $trening_id = $stmt->insert_id;
    echo "Vnos uspešen!";

    if (isset($_FILES['fileToUpload']) && $_FILES['fileToUpload']['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['fileToUpload']['tmp_name'];
        $fileName = $_FILES['fileToUpload']['name'];
        $fileSize = $_FILES['fileToUpload']['size'];
        $fileType = $_FILES['fileToUpload']['type'];
        $fileNameCmps = explode(".", $fileName);
        $fileExtension = strtolower(end($fileNameCmps));

        $allowedfileExtensions = array('jpg', 'gif', 'png', 'jpeg');

        if (in_array($fileExtension, $allowedfileExtensions)) {
            $uploadFileDir = 'slike/';
            $newFileName = md5(time() . $fileName) . '.' . $fileExtension;
            $dest_path = $uploadFileDir . $newFileName;

            if (move_uploaded_file($fileTmpPath, $dest_path)) {
                $slika_id = insertSlika($link, $dest_path);
                if ($slika_id !== false) {
                    $update_sql3 = "UPDATE treningi SET slika_id = ? WHERE id = ?";
                    $stmt4 = $link->prepare($update_sql3);
                    $stmt4->bind_param('ii', $slika_id, $trening_id);
                    if ($stmt4->execute()) {
                        setcookie('error',"Vnos uspešen.");
                        header('Location: treningi_overlook.php');
                    } else {
                        echo "Vnos ni uspel";
                    }
                } else {
                    echo "Vnos ni uspel";
                }
            } else
                setcookie('error','There was some error moving the file to the upload directory. Please make sure the upload directory is writable by the web server.') ;
                header('Location: treningi_overlook.php');
            }
        } else {
            setcookie('error', 'Upload failed. Allowed file types: ' . implode(',', $allowedfileExtensions));
            header('Location: treningi_overlook.php');
        }
    } else {
        setcookie('error',"Vnos brez slike uspešen.");
        header('Location: treningi_overlook.php');
    }
 else {
    setcookie('error',"Prišlo je do neznane napake.");
    header('Location: treningi_overlook.php');
}

function insertSlika($link, $url)
{
    $slika_sql = "INSERT INTO slike (url) VALUES (?)";
    $stmt = $link->prepare($slika_sql);
    $stmt->bind_param('s', $url);
    if ($stmt->execute()) {
        return $stmt->insert_id;
    } else {
        return false;
    }
}
?>
