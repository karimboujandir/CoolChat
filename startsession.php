<?php
session_start();
//var_dump($_SESSION);
if (!isset($_SESSION['user']['email'])) {
    header('Location: index.php');
    exit;
}
?>