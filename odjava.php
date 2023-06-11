<?php
//delete cookie id and prijava
$_SESSION['id'] = null;
$_SESSION['zival_id'] = null;
$_SESSION['admin'] = null;
setcookie('prijava', "Odjava uspešna.");
setcookie('good',"", time()- 3600);
header('Location: index.php');
?>