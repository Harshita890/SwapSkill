<?php
session_start();

$db_host = 'localhost';
$db_user = 'root';
$db_pass = '';
$db_name = 'skillswap';

$conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$error = $success = '';

$conn->query("CREATE TABLE IF NOT EXISTS user_profiles (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    bio TEXT,
    skills VARCHAR(255),
    location VARCHAR(255),
    FOREIGN KEY (user_id) REFERENCES users(id)
)");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $bio = $conn->real_escape_string($_POST['bio'] ?? '');
    $skills = $conn->real_escape_string($_POST['skills'] ?? '');
    $location = $conn->real_escape_string($_POST['location'] ?? '');
    
    $check = $conn->query("SELECT id FROM user_profiles WHERE user_id = $user_id");
    
    if ($check->num_rows > 0) {
        $sql = "UPDATE user_profiles SET bio='$bio', skills='$skills', location='$location' WHERE user_id=$user_id";
    } else {
        $sql = "INSERT INTO user_profiles (user_id, bio, skills, location) VALUES ($user_id, '$bio', '$skills', '$location')";
    }
    
    if ($conn->query($sql)) {
        $success = "Profile updated successfully!";
    } else {
        $error = "Error updating profile: " . $conn->error;
    }
}

$profile = ['bio' => '', 'skills' => '', 'location' => ''];
$result = $conn->query("SELECT bio, skills, location FROM user_profiles WHERE user_id = $user_id");
if ($result && $result->num_rows > 0) {
    $profile = $result->fetch_assoc();
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SkillSwap - Profile</title>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="css.css">
</head>
<body>
    <div class="sidebar">
        <h2>SkillSwap</h2>
        <ul>
            <li><a href="dashboard.php"><i class="fas fa-chart-line"></i> Dashboard</a></li>
            <li class="active"><a href="profile.php"><i class="fas fa-user"></i> Profile</a></li>
            <li><a href="skills.php"><i class="fas fa-graduation-cap"></i> Skills</a></li>
            <li><a href="messages.php"><i class="fas fa-comment-alt"></i> Messages</a></li>
            <li><a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
        </ul>
    </div>
    <div class="main-content">
        <div class="top-bar">
            <div class="search-container">
                <i class="fas fa-search"></i>
                <input type="text" placeholder="Search for skills, courses or experts...">
            </div>
            <div class="welcome-text">
                Welcome back, <span><?php echo htmlspecialchars($_SESSION['username']); ?></span>
            </div>
        </div>
        
        <div class="profile-container">
            <h1>My Profile</h1>
            
            <?php if ($error): ?>
                <div class="error"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>
            
            <?php if ($success): ?>
                <div class="success"><?= htmlspecialchars($success) ?></div>
            <?php endif; ?>
            
            <form method="post">
                <div class="form-group">
                    <label>Bio:</label>
                    <textarea name="bio"><?= htmlspecialchars($profile['bio']) ?></textarea>
                </div>
                
                <div class="form-group">
                    <label>Skills (comma separated):</label>
                    <input type="text" name="skills" value="<?= htmlspecialchars($profile['skills']) ?>">
                </div>
                
                <div class="form-group">
                    <label>Location:</label>
                    <input type="text" name="location" value="<?= htmlspecialchars($profile['location']) ?>">
                </div>
                
                <button type="submit"><i class="fas fa-save"></i> Save Profile</button>
            </form>
            
            <div class="dashboard-box">
                <a href="dashboard.php"><i class="fas fa-arrow-left"></i> Back to Dashboard</a>
            </div>
        </div>
    </div>
</body>
</html>