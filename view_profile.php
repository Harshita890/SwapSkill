<?php
session_start();
$conn = new mysqli("localhost", "root", "", "skillswap");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (!isset($_GET['user_id'])) {
    echo "User not specified.";
    exit;
}

$user_id = intval($_GET['user_id']);
$userQuery = $conn->query("SELECT username, email FROM users WHERE id = $user_id");
$profileQuery = $conn->query("SELECT bio, skills, location FROM user_profiles WHERE user_id = $user_id");

if ($userQuery->num_rows === 0) {
    echo "User not found.";
    exit;
}

$user = $userQuery->fetch_assoc();
$profile = ['bio' => '', 'skills' => '', 'location' => ''];

if ($profileQuery->num_rows > 0) {
    $profile = $profileQuery->fetch_assoc();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title><?php echo htmlspecialchars($user['username']); ?> - Profile</title>
    <link rel="stylesheet" href="css.css">
</head>
<body>
<div class="main-content">
    <h2><?php echo htmlspecialchars($user['username']); ?>'s Public Profile</h2>
    <p><strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?></p>
    <p><strong>Bio:</strong> <?php echo nl2br(htmlspecialchars($profile['bio'])); ?></p>
    <p><strong>Skills:</strong> <?php echo htmlspecialchars($profile['skills']); ?></p>
    <p><strong>Location:</strong> <?php echo htmlspecialchars($profile['location']); ?></p>
    <br>
    <a href="skills.php">← Back to Skills</a>
</div>
</body>
</html>
