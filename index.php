<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SkillSwap - Home</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #804e69;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            flex-direction: column;
            background: url('./assets/images/background_pic.webp') no-repeat center center;
            background-size: cover;
        }
        .container {
            background: #fff;
            padding: 2rem;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            text-align: center;
            max-width: 400px;
            width: 100%;
        }
        h1 {
            color: #333;
            margin-bottom: 1rem;
        }
        p {
            color: #666;
            margin-bottom: 1.5rem;
        }
        .btn {
            display: inline-block;
            padding: 0.75rem 1.5rem;
            margin: 0.5rem;
            font-size: 1rem;
            color: #fff;
            background-color: #37212d;
            border: none;
            border-radius: 4px;
            text-decoration: none;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        .btn:hover {
            background-color: #060405;
        }
        .btn-secondary {
            background-color: #6c757d;
        }
        .btn-secondary:hover {
            background-color: #060405;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Welcome to SkillSwap</h1>
        <p>Let's exchange skills!</p>

        <p>
            <?php 
            if (isset($_SESSION['user_id']) && isset($_SESSION['username'])) {
                echo "You are logged in as <strong>" . htmlspecialchars($_SESSION['username']) . "</strong>.";
            } else {
                echo "Welcome! Please login to start SkillSwapping.";
            }
            ?>
        </p>

        <a href="<?php echo isset($_SESSION['user_id']) ? 'dashboard.php' : 'login.php'; ?>" class="btn">
            <?php echo isset($_SESSION['user_id']) ? 'Go to Dashboard' : 'Login'; ?>
        </a>

        <?php if (!isset($_SESSION['user_id'])): ?>
            <a href="register.php" class="btn btn-secondary">Register</a>
        <?php endif; ?>
    </div>
</body>
</html>
