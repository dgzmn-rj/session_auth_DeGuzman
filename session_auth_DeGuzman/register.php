<?php
require 'db.php';
$message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    // I-hash ang password para secure
    $hash = password_hash($password, PASSWORD_DEFAULT);

    // Check kung existing na ang username/email
    $check = $conn->prepare("SELECT id FROM users WHERE username=? OR email=?");
    $check->bind_param("ss", $username, $email);
    $check->execute();

    if ($check->get_result()->num_rows > 0) {
        $message = "<span style='color:red;'>Username or Email already exists!</span>";
    } else {
        $stmt = $conn->prepare("INSERT INTO users (username, email, password_hash) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $username, $email, $hash);

        if ($stmt->execute()) {
            $message = "<span style='color:green;'>Registration successful! <a href='index.php'>Login here</a></span>";
        } else {
            $message = "Error: " . $conn->error;
        }
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Register - AuthSystem</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f7f6;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .card {
            background: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 300px;
            text-align: center;
        }

        input {
            width: 90%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        button {
            width: 100%;
            padding: 10px;
            background: #28a745;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }
    </style>
</head>

<body>
    <div class="card">
        <h2 style="color:#28a745;">Create Account</h2>
        <p style="color:gray; font-size: 14px;">Sign up to get started</p>

        <?php echo "<p style='font-size:14px;'>$message</p>"; ?>

        <form method="POST">
            <input type="text" name="username" placeholder="Enter username" required>
            <input type="email" name="email" placeholder="name@example.com" required>
            <input type="password" name="password" placeholder="Create a password" required>
            <button type="submit">Register</button>
        </form>
        <p style="font-size: 12px; margin-top: 15px;">Already have an account? <a href="index.php">Login here</a></p>
    </div>
</body>

</html>