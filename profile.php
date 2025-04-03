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
<html>
<head>
    <title>My Profile</title>
    <style>
        body { font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto; padding: 20px; }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; }
        input, textarea { width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px; }
        textarea { height: 100px; }
        button { background: #432937; color: white; border: none; padding: 10px 15px; border-radius: 4px; cursor: pointer; }
        .error { color: red; margin-bottom: 15px; }
        .success { color: green; margin-bottom: 15px; }
        .dashboard-box {
            margin-top: 15px;
            text-align: center;
        }
        .dashboard-box a {
            display: inline-block;
            padding: 10px 15px;
            background: #432937;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            transition: 0.3s;
        }
        .dashboard-box a:hover {
            background: #5a3e50;
        }
    </style>
</head>
<body>
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
        
        <button type="submit">Save Profile</button>
    </form>
    
    <div class="dashboard-box">
        <a href="dashboard.php">← Back to Dashboard</a>
    </div>
</body>
</html>
