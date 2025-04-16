<?php
session_start();
require 'db.php'; 

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Handle adding new skill
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_skill'])) {
    $skill_name = htmlspecialchars($_POST['skill_name']);
    $description = htmlspecialchars($_POST['skill_description']);
    $video_link = isset($_POST['video_link']) ? htmlspecialchars($_POST['video_link']) : null;

    $query = "INSERT INTO skills (skill_name, description, video_link, user_id, created_at)
              VALUES (?, ?, ?, ?, NOW())";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sssi", $skill_name, $description, $video_link, $_SESSION['user_id']);
    $stmt->execute();

    echo "<script>alert('Skill added successfully!'); window.location='skills.php';</script>";
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>SkillSwap - Skills</title>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="css.css">
</head>
<body>

<div class="sidebar">
    <h2>SkillSwap</h2>
    <ul>
        <li><a href="dashboard.php"><i class="fas fa-chart-line"></i> Dashboard</a></li>
        <li><a href="profile.php"><i class="fas fa-user"></i> Profile</a></li>
        <li class="active"><a href="skills.php"><i class="fas fa-graduation-cap"></i> Skills</a></li>
        <li><a href="messages.php"><i class="fas fa-comment-alt"></i> Messages</a></li>
        <li><a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
    </ul>
</div>

<div class="main-content">
    <div class="top-bar">
        <div class="search-container">
            <i class="fas fa-search"></i>
            <input type="text" placeholder="Search skills, users, resources...">
        </div>
        <div class="welcome-text">
            Welcome back, <span><?php echo htmlspecialchars($_SESSION['username']); ?></span>
        </div>
    </div>

    <div class="skills-section">
        <div class="skills-header">
            <h2>My Skills</h2>
            <button class="video-call-btn" id="addSkillBtn"><i class="fas fa-plus"></i> Add Skill</button>
        </div>

        <div class="skills-grid">
            <?php
            $query = "SELECT * FROM skills WHERE user_id = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("i", $_SESSION['user_id']);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo '<div class="skill-card">';
                    echo '<h3>' . htmlspecialchars($row['skill_name']) . '</h3>';
                    echo '<p>' . htmlspecialchars($row['description']) . '</p>';
                    echo '<div class="skill-level"><div class="skill-level-fill" style="width: 80%;"></div></div>';
                    echo '<div class="skill-actions">';
                    echo '<button class="schedule-btn"><i class="fas fa-edit"></i> Edit</button>';

                    if (!empty($row['video_link']) && $_SESSION['premium'] == 1) {
                        echo '<a class="video-call-btn" href="' . htmlspecialchars($row['video_link']) . '" target="_blank">
                                 <i class="fas fa-video"></i> Video Call
                              </a>';
                    }

                    echo '</div></div>';
                }
            } else {
                echo "<p>No skills added yet. Click 'Add Skill' to get started!</p>";
            }
            ?>
        </div>
    </div>
</div>

<div class="modal" id="addSkillModal">
    <div class="modal-content">
        <div class="modal-header">
            <h3>Add New Skill</h3>
            <button class="close-btn" id="closeModalBtn">&times;</button>
        </div>
        <form method="POST" action="skills.php">
            <div class="form-group">
                <label for="skill_name">Skill Name</label>
                <input type="text" id="skill_name" name="skill_name" required>
            </div>
            <div class="form-group">
                <label for="skill_description">Description</label>
                <textarea id="skill_description" name="skill_description" required></textarea>
            </div>
            <div class="form-group">
                <label for="video_link">Video Resource (optional)</label>
                <input type="url" id="video_link" name="video_link" placeholder="https://example.com/video">
            </div>
            <div class="form-actions">
                <button type="button" class="schedule-btn" id="cancelBtn">Cancel</button>
                <button type="submit" class="video-call-btn" name="add_skill">Save Skill</button>
            </div>
        </form>
    </div>
</div>

<script>
    const addSkillBtn = document.getElementById('addSkillBtn');
    const closeModalBtn = document.getElementById('closeModalBtn');
    const cancelBtn = document.getElementById('cancelBtn');
    const modal = document.getElementById('addSkillModal');

    addSkillBtn.addEventListener('click', () => {
        modal.classList.add('active');
    });

    closeModalBtn.addEventListener('click', () => {
        modal.classList.remove('active');
    });

    cancelBtn.addEventListener('click', () => {
        modal.classList.remove('active');
    });

    modal.addEventListener('click', (e) => {
        if (e.target === modal) {
            modal.classList.remove('active');
        }
    });
</script>

</body>
</html>
