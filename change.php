<?php
require_once 'connect.php';
require_once 'cookie.php';

$id = $_COOKIE['id'];
$sql = "SELECT * FROM uporabniki WHERE id = $id AND admin = 1;";
$result = mysqli_query($conn, $sql);
$query = mysqli_num_rows($result);

// modify the if statement to check if id exists in database
if ($query > 0) {
    $id = $_COOKIE['id'];
    $mail = $_GET['uporabnikid'];
    $sql = "SELECT * FROM uporabniki WHERE email = '".$mail."';";
    $result = mysqli_query($conn, $sql);
    $row=mysqli_fetch_array($result);
    $uporabnik_id = $row['id'];
    $zival = $_COOKIE['zival_id'];
    $date = strtotime("+7 day");
    $datum = date('Y-m-d', $date);
    $ime = $_GET['ime'];
    $date = $_GET['datum'];
    $posvojen = $_GET['posvojen'];
    if($posvojen === null){
        $posvojen = 0;
    }
    
    $update_sql = "UPDATE zivali SET ime = '".$ime."', datum_r = '".$date."', posvojen = ".$posvojen." 
    WHERE id = ".$zival.";";
    if ($conn->query($update_sql) === TRUE) {
        // get the ID of the newly created reservation
        $insert_sql = "INSERT INTO rezervacija (datum, uporabnik_id, zival_id)
        VALUES ('".$datum."', ".$uporabnik_id.", ".$zival.")";
        if ($conn->query($insert_sql) === TRUE) {
            $rezervacija_id = mysqli_insert_id($conn);
            $update_sql2 = "UPDATE zivali SET rezervacija_id = ".$rezervacija_id." WHERE id = ".$zival.";";
            if ($conn->query($update_sql2) === TRUE) {
                if ($_FILES['slika']['error'] === UPLOAD_ERR_OK) {
                    $image_dir = 'img/';
                    $image_name = $_FILES['slika']['name'];
                    $image_tmp = $_FILES['slika']['tmp_name'];
                    $image_path = $image_dir . $image_name;
                
                    // Move the uploaded file to the desired directory
                    if (move_uploaded_file($image_tmp, $image_path)) {
                        // Image upload successful
                        echo "Image URL: " . $image_path;
                        $slika_sql = "INSERT INTO slike (url) VALUES ('".$image_path."');";
                        if ($conn->query($slika_sql) === TRUE){
                            $slika_id = mysqli_insert_id($conn);
                            $update_sql3 = "UPDATE zivali SET slika_id = ".$slika_id." id = ".$zival.";";
                            if ($conn->query($update_sql3) === TRUE) {
                                setcookie('prijava', "Sprememba uspešna.");
                                header('Location: admin.php');
                        }
                        else{
                            setcookie('prijava', "Error: " . $update_sql . "<br>" . $conn->error);
                            header('Location: admin.php');
                        }

                    } else {
                        // Error in moving the uploaded file
                        echo "Error uploading the image.";
                        exit();
                    }
                } else {
                    // Error in uploading the file
                    echo "Error: " . $_FILES['slika']['error'];
                    exit();
                }
            } else {
                setcookie('prijava', "Error: " . $update_sql . "<br>" . $conn->error);
                header('Location: admin.php');
            }
        } else {
            setcookie('prijava', "Error: " . $update_sql . "<br>" . $conn->error);
            header('Location: admin.php');
        }
    } else {
        setcookie('prijava', "Error: " . $sql . "<br>" . $conn->error);
        header('Location: admin.php');
    }
} else {
    header('Location: index.php');
}
}
?>