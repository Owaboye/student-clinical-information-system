<?php
require_once '../config/functions.php';
session_destroy();
header('Location: '.baseUrl('public/login.php'));
