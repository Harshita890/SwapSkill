<?php
session_start();
require("include/db.php");

if(!isset($_SESSION['username'])){
    header("location: login.php");
}

$query = "SELECT * FROM skills";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Skills List</title>
    <link rel="stylesheet" type="text/css" href="css.css">
</head>
<body>

<div class="main-content">
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
                        <a href="<?php echo $row['video_link']; ?>" target="_blank" class="schedule-btn">Watch Video</a>
                        <a href="edit_skill.php?id=<?php echo $row['id']; ?>" class="video-call-btn">Edit</a>
                    </div>
                </div>
            <?php } ?>
        </div>

    </div>
</div>

</body>
</html>
