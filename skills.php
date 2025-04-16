<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_skill'])) {

    $skill_name = htmlspecialchars($_POST['skill_name']);
    $skill_description = htmlspecialchars($_POST['skill_description']);
    $skill_level = intval($_POST['skill_level']);

    echo "<script>alert('Skill added successfully!');</script>";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
                <button class="video-call-btn" id="addSkillBtn">
                    <i class="fas fa-plus"></i> Add Skill
                </button>
            </div>
            <div class="skills-grid">
                <div class="skill-card">
                    <h3>Web Development</h3>
                    <p>HTML, CSS, JavaScript, PHP</p>
                    <div class="skill-level">
                        <div class="skill-level-fill" style="width: 85%"></div>
                    </div>
                    <div class="skill-actions">
                        <button class="schedule-btn">
                            <i class="fas fa-edit"></i> Edit
                        </button>
                        <button class="video-call-btn">
                            <i class="fas fa-share-alt"></i> Share
                        </button>
                    </div>
                </div>
                <div class="skill-card">
                    <h3>Graphic Design</h3>
                    <p>Photoshop, Illustrator</p>
                    <div class="skill-level">
                        <div class="skill-level-fill" style="width: 70%"></div>
                    </div>
                    <div class="skill-actions">
                        <button class="schedule-btn">
                            <i class="fas fa-edit"></i> Edit
                        </button>
                        <button class="video-call-btn">
                            <i class="fas fa-share-alt"></i> Share
                        </button>
                    </div>
                </div>
                <div class="skill-card">
                    <h3>Video Editing</h3>
                    <p>Premiere Pro, After Effects</p>
                    <div class="skill-level">
                        <div class="skill-level-fill" style="width: 60%"></div>
                    </div>
                    <div class="skill-actions">
                        <button class="schedule-btn">
                            <i class="fas fa-edit"></i> Edit
                        </button>
                        <button class="video-call-btn">
                            <i class="fas fa-share-alt"></i> Share
                        </button>
                    </div>
                </div>
                <div class="skill-card">
                    <h3>UI/UX Design</h3>
                    <p>Figma, Adobe XD, User Research</p>
                    <div class="skill-level">
                        <div class="skill-level-fill" style="width: 75%"></div>
                    </div>
                    <div class="skill-actions">
                        <button class="schedule-btn">
                            <i class="fas fa-edit"></i> Edit
                        </button>
                        <button class="video-call-btn">
                            <i class="fas fa-share-alt"></i> Share
                        </button>
                    </div>
                </div>
                <div class="skill-card">
                    <h3>Python Programming</h3>
                    <p>Django, Flask, Data Analysis</p>
                    <div class="skill-level">
                        <div class="skill-level-fill" style="width: 65%"></div>
                    </div>
                    <div class="skill-actions">
                        <button class="schedule-btn">
                            <i class="fas fa-edit"></i> Edit
                        </button>
                        <button class="video-call-btn">
                            <i class="fas fa-share-alt"></i> Share
                        </button>
                    </div>
                </div>
                <div class="skill-card">
                    <h3>Digital Marketing</h3>
                    <p>SEO, Social Media, Analytics</p>
                    <div class="skill-level">
                        <div class="skill-level-fill" style="width: 80%"></div>
                    </div>
                    <div class="skill-actions">
                        <button class="schedule-btn">
                            <i class="fas fa-edit"></i> Edit
                        </button>
                        <button class="video-call-btn">
                            <i class="fas fa-share-alt"></i> Share
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Skill Modal -->
    <div class="modal" id="addSkillModal">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Add New Skill</h3>
                <button class="close-btn" id="closeModalBtn">&times;</button>
            </div>
            <form method="POST" action="skills.php">
                <div class="form-group">
                    <label for="skill_name">Skill Name</label>
                    <input type="text" id="skill_name" name="skill_name" required placeholder="e.g., Web Development">
                </div>
                <div class="form-group">
                    <label for="skill_description">Description</label>
                    <textarea id="skill_description" name="skill_description" required placeholder="Describe your skill, technologies used, etc."></textarea>
                </div>
                <div class="form-group">
                    <label for="skill_level">Skill Level</label>
                    <select id="skill_level" name="skill_level" required>
                        <option value="">Select your skill level</option>
                        <option value="20">Beginner (1-20%)</option>
                        <option value="40">Intermediate (21-40%)</option>
                        <option value="60">Competent (41-60%)</option>
                        <option value="80">Proficient (61-80%)</option>
                        <option value="100">Expert (81-100%)</option>
                    </select>
                </div>
                <div class="form-actions">
                    <button type="button" class="schedule-btn" id="cancelBtn">Cancel</button>
                    <button type="submit" class="video-call-btn" name="add_skill