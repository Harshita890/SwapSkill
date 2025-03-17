<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SkillSwap - Dashboard</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <div class="container">
        <h1>Welcome, <?php echo $_SESSION['username']; ?>!</h1>
        <p>This is your dashboard. You can manage your profile and skills here.</p>
        <a href="profile.php" class="btn">View Profile</a>
        <a href="skills.php" class="btn">View Skills</a>
        <a href="logout.php" class="btn btn-secondary">Logout</a>
    </div>
</body>
</html>