<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Database connection
$conn = new mysqli("localhost", "root", "", "userregistration");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get user data from the database
$user_id = $_SESSION['user_id'];
$sql = "SELECT * FROM users WHERE id = '$user_id'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $name = $row['name'];
    $email = $row['email'];
    $gender = $row['gender'];
    $weight = $row['weight'];
    $height = $row['height'];
    $age = $row['age'];
    $profile_picture = $row['profile_picture']; // Get profile picture filename
} else {
    echo "User not found.";
    exit();
}

$conn->close();
?>