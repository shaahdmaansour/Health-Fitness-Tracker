<?php
// settings.php
session_start();
include('userregistration');

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$query = "SELECT * FROM users WHERE id='$user_id'";
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_assoc($result);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $username = $_POST['username'];
    $email = $_POST['email'];

    $update_query = "UPDATE users SET name='$name', username='$username', email='$email' WHERE id='$user_id'";
    if (mysqli_query($conn, $update_query)) {
        echo "Profile updated successfully!";
    } else {
        echo "Error updating profile: " . mysqli_error($conn);
    }
}

?>

<form method="POST">
    <input type="text" name="name" value="<?= $row['name'] ?>" required><br>
    <input type="text" name="username" value="<?= $row['username'] ?>" required><br>
    <input type="email" name="email" value="<?= $row['email'] ?>" required><br>
    <button type="submit">Update Settings</button>
</form>
