<?php
//delete cookie id and prijava
setcookie('id', "", time() - 3600);
setcookie('prijava', "Odjava uspešna.");
setcookie('admin', "", time() - 3600);
setcookie('zival_id', "", time() - 3600);
setcookie('good',"", time()- 3600);
header('Location: index.php');
?>