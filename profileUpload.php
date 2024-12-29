<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['profile_picture'])) {
    $profile_picture = $_FILES['profile_picture'];
    $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
    $max_size = 2 * 1024 * 1024; // 2MB

    if (in_array($profile_picture['type'], $allowed_types) && $profile_picture['size'] <= $max_size) {
        $upload_dir = 'uploads/';
        $upload_file = $upload_dir . basename($profile_picture['name']);

        if (move_uploaded_file($profile_picture['tmp_name'], $upload_file)) {
            // Update profile picture in the database
            $conn = new mysqli("localhost", "root", "", "userregistration");
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            $user_id = $_SESSION['user_id'];
            $stmt = $conn->prepare("UPDATE users SET profile_picture = ? WHERE id = ?");
            $stmt->bind_param("si", $upload_file, $user_id);
            $stmt->execute();

            // Redirect back to profile page
            header("Location: userProfile.php");
            exit();
        } else {
            echo "Error uploading file.";
        }
    } else {
        echo "Invalid file type or file size exceeds limit.";
    }
}
?>