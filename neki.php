<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once 'connect.php';
require_once 'cookie.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
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
                            echo "Uspešen vnos slike";
                        } else {
                            echo "Vnos ni uspel";
                        }
                    } else {
                        echo "Vnos ni uspel";
                    }
                } else {
                    echo 'There was some error moving the file to the upload directory. Please make sure the upload directory is writable by the web server.';
                }
            } else {
                echo 'Upload failed. Allowed file types: ' . implode(',', $allowedfileExtensions);
            }
        } else {
            echo "Vnos brez slike uspešen";
        }
    } else {
        echo "ne dela";
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

<!DOCTYPE html>
<html lang="sl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Miha Šafranko"/>
	<meta name="author" content="Miha Šafranko" />

    <title>Vnos</title>
</head>
<body>
  <?php
  require_once 'cookie.php';
  require_once 'connect.php';
  ?>
<div class="container">
	<div class="screen">
		<div class="screen__content">
			<form class="login" id="spremembe" action="neki.php" method="post" enctype="multipart/form-data">
				<div class="login__field">
					<i class="login__icon fas fa-user"></i>
					<label for="ime">Ime:</label><br>
                    <input type="text" id="ime" name="ime" required><br>
				</div>
				<div class="login__field">
					<i class="login__icon fas fa-lock"></i>
					<label for="datum">Datum rojstva:</label><br>
                    <input type="date" id="datum" name="datum" class="login_input" required><br>
				</div>
                <div class="login__field">
					<i class="login__icon fas fa-lock"></i>
					<label for="posvojen">Posvojen:</label><br>
                    <input type="checkbox" id="posvojen" name="posvojen" class="login_input"><br>
				</div>
                <div class="login__field">
					<i class="login__icon fas fa-lock"></i>
					<label for="slika">Slika:</label><br>
                    <input type="file" id="slika" class="login_input" name="slika"><br>
				</div>

				<br>
                <datalist id="zivali">
                    <?php
                    $sql = "SELECT ime FROM zivali";
                    $result = mysqli_query($conn, $sql);
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<option value=" . $row['ime'] . ">";
                    }
                    setcookie('register', '');
                    ?>
                </datalist>
                <datalist id="uporabniki">
                    <?php
                    $sql = "SELECT * FROM uporabniki";
                    $result = mysqli_query($conn, $sql);
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<option value=" . $row['email'] . ">";
                    }
                    setcookie('register', '');
                    ?>
                </datalist>
				</div>
				<button class="button login__submit">
					<span class="button__text">Pošlji</span>
					<i class="button__icon fas fa-chevron-right"></i>
				</button>				
			</form>
		</div>
		<div class="screen__background">
			<span class="screen__background__shape screen__background__shape4"></span>
			<span class="screen__background__shape screen__background__shape3"></span>		
			<span class="screen__background__shape screen__background__shape2"></span>
			<span class="screen__background__shape screen__background__shape1"></span>
		</div>		
	</div>
</div>
</body>
</html>
