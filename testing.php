<?php
session_start();
$message = ''; 

$_SESSION['message'] = $message;
header("Location: fileupload.php");