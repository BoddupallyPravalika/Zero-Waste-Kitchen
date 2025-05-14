<?php
session_start();
if (!isset($_SESSION["user"])) {
   header("Location: login.php");
   exit();
}

// Redirect based on user type
if (isset($_SESSION["is_admin"]) && $_SESSION["is_admin"] === true) {
    header("Location: admin_dashboard.php");
    exit();
} else if ($_SESSION["user_type"] === 'donor') {
    header("Location: donor_dashboard.php");
    exit();
} else if ($_SESSION["user_type"] === 'receiver') {
    header("Location: receiver_dashboard.php");
    exit();
}
?>
