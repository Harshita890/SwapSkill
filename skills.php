<?php
session_start();
require("include/db.php");

if(!isset($_SESSION['username'])){
    header("location: login.php");
}

// Simple premium check (add to db.php or keep here)
$isPremium = false;
if(isset($_SESSION['user_id'])) {
    $result = mysqli_query($conn, "SELECT is_premium FROM users WHERE id = ".$_SESSION['user_id']);
    $user = mysqli_fetch_assoc($result);
    $isPremium = $user['is_premium'] ?? false;
}

$query = "SELECT * FROM skills";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Skills List</title>
    <link rel="stylesheet" type="text/css" href="css.css">
    <style>
        .premium-lock { position: relative; }
        .premium-lock:after {
            content: "🔒";
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
        }
    </style>
</head>
<body>

<div class="main-content">
    <!-- Your existing top bar remains exactly the same -->
    <div class="top-bar">
        <div class="welcome-text">Welcome, <span><?php echo $_SESSION['username']; ?>!</span></div>
        <div>
            <a href="dashboard.php" class="schedule-btn">← Back to Dashboard</a>
            <a href="add_skill.php" class="video-call-btn">+ Add Skill</a>
        </div>
    </div>

    <div class="skills-section">
        <div class="skills-header">
            <h2>Available Skills</h2>
        </div>

        <div class="skills-grid">
            <?php while($row = mysqli_fetch_assoc($result)) { ?>
                <div class="skill-card">
                    <h3><?php echo $row['skill_name']; ?></h3>
                    <p><?php echo $row['description']; ?></p>
                    <div class="skill-actions">
                        <?php if($isPremium): ?>
                            <a href="<?php echo $row['video_link']; ?>" target="_blank" class="schedule-btn">Watch Video</a>
                        <?php else: ?>
                            <a href="upgrade.php" class="schedule-btn premium-lock">Watch Video</a>
                        <?php endif; ?>
                        <a href="edit_skill.php?id=<?php echo $row['id']; ?>" class="video-call-btn">Edit</a>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</div>

</body>
</html>