<?php
// goals.php
session_start();
include('userregistration');

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$query = "SELECT * FROM goals WHERE user_id='$user_id'";
$result = mysqli_query($conn, $query);
while ($goal = mysqli_fetch_assoc($result)) {
    echo "<p>" . $goal['title'] . ": " . $goal['description'] . "</p>";
}
?>