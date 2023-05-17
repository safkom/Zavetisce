<?php
/*

*/


require_once 'connect.php';
require_once 'cookie.php';

$id = $_COOKIE['id'];
$sql = "SELECT * FROM uporabniki WHERE id = $id AND admin = 1;";
$result = mysqli_query($conn, $sql);
$query = mysqli_num_rows($result);

// Modify the if statement to check if the ID exists in the database
if ($query > 0) {
    $id = $_COOKIE['id'];
    $mail = $_GET['uporabnikid'];
    $sql = "SELECT * FROM uporabniki WHERE email = '".$mail."';";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($result);
    $uporabnik_id = $row['id'];
    $zival = $_COOKIE['zival_id'];
    $date = strtotime("+7 day");
    $datum = date('Y-m-d', $date);
    $ime = $_GET['ime'];
    $date = $_GET['datum'];
    $posvojen = $_GET['posvojen'];
    if ($posvojen === null) {
        $posvojen = 0;
    }

    $update_sql = "UPDATE zivali SET ime = '".$ime."', datum_r = '".$date."', posvojen = ".$posvojen." 
    WHERE id = ".$zival.";";
    if ($conn->query($update_sql) === TRUE) {
        // Get the ID of the newly created reservation
        $insert_sql = "INSERT INTO rezervacija (datum, uporabnik_id, zival_id)
        VALUES ('".$datum."', ".$uporabnik_id.", ".$zival.")";
        if ($conn->query($insert_sql) === TRUE) {
            $rezervacija_id = mysqli_insert_id($conn);
            $update_sql2 = "UPDATE zivali SET rezervacija_id = ".$rezervacija_id." WHERE id = ".$zival.";";
            if ($conn->query($update_sql2) === TRUE) {
                if (isset($_POST['uploadBtn']) && $_POST['uploadBtn'] == 'Upload')
{
  if (isset($_FILES['uploadedFile']) && $_FILES['uploadedFile']['error'] === UPLOAD_ERR_OK)
  {
    // get details of the uploaded file 
    $fileTmpPath = $_FILES['uploadedFile']['tmp_name'];
    $fileName = $_FILES['uploadedFile']['name'];
    $fileSize = $_FILES['uploadedFile']['size'];
    $fileType = $_FILES['uploadedFile']['type'];
    $fileNameCmps = explode(".", $fileName);
    $fileExtension = strtolower(end($fileNameCmps));
    // sanitize file-name 
    $newFileName = md5(time() . $fileName) . '.' . $fileExtension;
    // check if file has one of the following extensions 
    $allowedfileExtensions = array('jpg', 'gif', 'png', 'zip', 'txt', 'xls', 'doc');
    if (in_array($fileExtension, $allowedfileExtensions))
    {
      // directory in which the uploaded file will be moved 
      $uploadFileDir = './img/';
      $dest_path = $uploadFileDir . $newFileName;
      if(move_uploaded_file($fileTmpPath, $dest_path)) 
      {
        setcookie('prijava','File is successfully uploaded.');
        $slika_sql = "INSERT INTO slike (url) VALUES ('".$dest_path."');";
                        if ($conn->query($slika_sql) === TRUE) {
                            $slika_id = mysqli_insert_id($conn);
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
                        }
      }
      else 
      {
        setcookie('prijava','There was some error moving the file to upload directory. Please make sure the upload directory is writable by web server.');
        header('Loaction: admin.php');
    }

    }
    else
    {
        setcookie('prijava', 'Upload failed. Allowed file types: ' . implode(',', $allowedfileExtensions));
        header('Loaction: admin.php');
    }
  }
  else
  {
    setcookie('prijava','There is some error in the file upload. Please check the following error' . $_FILES['uploadedFile']['error']);
  }
}
                         else {
                            setcookie('prijava', "Error: " . $conn->error);
                            header('Location: admin.php');
                            exit();
                        } 
                    } else {
                        // Error in uploading the file
                        echo "Error uploading the image.";
                        exit();
                    }
                } else {
                    setcookie('prijava', "Error: " . $conn->error);
                    header('Location: admin.php');
                    exit();
                }
            } else {
                setcookie('prijava', "Error: " . $conn->error);
                header('Location: admin.php');
                exit();
            }
        } else {
            setcookie('prijava', "Error: " . $conn->error);
            header('Location: admin.php');
            exit();
        }
?>
