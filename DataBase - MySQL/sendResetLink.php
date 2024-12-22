<?php
// Database connection
$servername = "localhost";
$username = "root";  // Change if necessary
$password = "";      // Change if necessary
$dbname = "userregistration";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];

    // Check if the email exists in the database
    $sql = "SELECT * FROM users WHERE email='$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // User found, generate reset token
        $token = bin2hex(random_bytes(50)); // Generate a unique token

        // Insert the reset token
        $stmt = $conn->prepare("INSERT INTO password_resets (email, token, expiry_time) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $email, $token, $expiry_time);
        $stmt->execute();


        // Save the token in the database with expiration time (1 hour)
        $expiry_time = date("Y-m-d H:i:s", strtotime("+1 hour"));
        $stmt = $conn->prepare("INSERT INTO password_resets (email, token, expiry_time) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $email, $token, $expiry_time);
        $stmt->execute();

        // Send the password reset email
        $reset_link = "http://yourwebsite.com/resetPassword.php?token=" . $token;
        $subject = "Password Reset Request";
        $message = "Hello, \n\nTo reset your password, please click the link below:\n$reset_link\n\nIf you did not request a password reset, please ignore this email.";
        $headers = "From: no-reply@yourwebsite.com";

        if (mail($email, $subject, $message, $headers)) {
            echo "Password reset link has been sent to your email!";
        } else {
            echo "Error sending email.";
        }
    } else {
        echo "No user found with that email address.";
    }

    $conn->close();
}
?>