<?php
// home.php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

echo "Welcome to your Home Page!";
echo "<a href='logout.php'>Logout</a>";
?>
