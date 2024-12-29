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

$token = $_GET['token'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Collect form data
    $new_password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if ($new_password !== $confirm_password) {
        echo "Passwords do not match!";
        exit();
    }

    // Hash the new password
    $hashed_password = password_hash($new_password, PASSWORD_BCRYPT);

    // Verify the token and expiration time
    $sql = "SELECT * FROM password_resets WHERE token='$token' AND expiry_time > NOW()";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Token is valid, update the password
        $row = $result->fetch_assoc();
        $email = $row['email'];

        // Update the user's password in the users table
        $stmt = $conn->prepare("UPDATE users SET password=? WHERE email=?");
        $stmt->bind_param("ss", $hashed_password, $email);
        $stmt->execute();

        // Delete the reset token (one-time use)
        $conn->query("DELETE FROM password_resets WHERE token='$token'");

        echo "Password has been reset successfully!";
    } else {
        echo "Invalid or expired token.";
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <style>
        /* Same styling as the other pages */
        html, body {
            height: 100%;
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #f8f8f8;
        }
        body {
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .container {
            width: 320px;
            padding: 25px 20px;
            background: #fff;
            border: 1px solid #ddd;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        h2 {
            margin-bottom: 20px;
            font-size: 1.5rem;
            color: #333;
        }
        input[type="password"] {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
            font-size: 1rem;
        }
        button {
            width: 100%;
            padding: 12px;
            margin-top: 15px;
            background: black;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1rem;
        }
        button:hover {
            background: #333;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Reset Your Password</h2>
        <form action="reset-password.php?token=<?php echo $token; ?>" method="POST">
            <input type="password" name="password" placeholder="New Password" required>
            <input type="password" name="confirm_password" placeholder="Confirm Password" required>
            <button type="submit">Reset Password</button>
        </form>        
    </div>
</body>
</html>