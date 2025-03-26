<?php
session_start();
include 'include/db.php'; // Ensure this file correctly connects to your database

$error = ''; // Variable to store error messages

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Ensure the input fields exist before accessing them
    $username = isset($_POST['username']) ? trim($_POST['username']) : '';
    $password = isset($_POST['password']) ? trim($_POST['password']) : '';

    // Debugging: Print POST data
    // echo "<pre>"; print_r($_POST); echo "</pre>";

    if (empty($username) || empty($password)) {
        $error = "Username and password are required!";
    } else {
        // Check if the username exists in the database
        $sql = "SELECT * FROM users WHERE username = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            if (password_verify($password, $user['password'])) {
                // Set session variables
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];

                // Redirect to dashboard
                header("Location: dashboard.php");
                exit();
            } else {
                $error = "Invalid password!";
            }
        } else {
            $error = "User not found!";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SkillSwap - Login</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #432937;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .container {
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 320px;
            text-align: center;
        }
        h1 {
            margin-bottom: 20px;
            color: #333;
        }
        input {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 16px;
        }
        button {
            width: 100%;
            padding: 10px;
            background-color: #432937;
            color: #fff;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
        }
        button:hover {
            background-color: #5a3d4d;
        }
        .message {
            margin-top: 15px;
            padding: 10px;
            border-radius: 4px;
            font-size: 14px;
        }
        .error {
            background-color: #ffebee;
            color: #c62828;
        }
        .success {
            background-color: #e8f5e9;
            color: #2e7d32;
        }
        p {
            margin-top: 15px;
            color: #666;
        }
        a {
            color: #120b0f;
            text-decoration: none;
        }
        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Login</h1>
        <?php if (!empty($error)): ?>
            <div class="message error"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>
        <form method="POST" action="">
            <label for="username">Username:</label>
            <input type="text" name="username" placeholder="Enter your username" required>

