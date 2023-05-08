<?php
//delete cookie id and prijava
setcookie('id', "", time() - 3600);
setcookie('prijava', "Odjava uspešna.");
header('Location: index.php');
?>