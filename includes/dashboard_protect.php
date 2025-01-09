<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: /Movie-Website/auth/login.php");
    exit();
}
?>
