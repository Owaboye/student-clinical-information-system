<?php
// session_start();
// var_dump($_SESSION['user']);
if (!isset($_SESSION['user'])) {
    header('Location: '.baseUrl('public/login.php'));
    exit;
}
$user = $_SESSION['user'];
