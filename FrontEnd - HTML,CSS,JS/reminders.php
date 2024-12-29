<?php
// reminders.php
session_start();
include('userregistration');

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$query = "SELECT * FROM reminders WHERE user_id='$user_id'";
$result = mysqli_query($conn, $query);
while ($reminder = mysqli_fetch_assoc($result)) {
    echo "<p>" . $reminder['reminder_time'] . ": " . $reminder['message'] . "</p>";
}
?>
