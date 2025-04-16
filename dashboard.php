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
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="css.css">
</head>
<body>
    <div class="sidebar">
        <h2>SkillSwap</h2>
        <ul>
            <li class="active"><a href="dashboard.php"><i class="fas fa-chart-line"></i> Dashboard</a></li>
            <li><a href="profile.php"><i class="fas fa-user"></i> Profile</a></li>
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
        <div class="stats">
            <div class="stat-card">
                <div class="icon"><i class="fas fa-book-open"></i></div>
                <h3>19</h3>
                <p>Lessons Completed</p>
            </div>
            <div class="stat-card">
                <div class="icon"><i class="fas fa-certificate"></i></div>
                <h3>7</h3>
                <p>Skills Achieved</p>
            </div>
            <div class="stat-card">
                <div class="icon"><i class="fas fa-users"></i></div>
                <h3>23</h3>
                <p>Learning Partners</p>
            </div>
        </div>
        
        <div class="learning-resources">
            <h3>Learning Resources</h3>
            <div class="resource-grid">
                <div class="resource-card">
                    <div class="resource-icon book">
                        <i class="fas fa-book"></i>
                    </div>
                    <div class="resource-info">
                        <h4>Web Development Fundamentals</h4>
                        <p>Essential HTML, CSS & JavaScript</p>
                    </div>
                </div>
                <div class="resource-card">
                    <div class="resource-icon video">
                        <i class="fas fa-play"></i>
                    </div>
                    <div class="resource-info">
                        <h4>Design Thinking Workshop</h4>
                        <p>Problem-solving framework</p>
                    </div>
                </div>
                <div class="resource-card">
                    <div class="resource-icon code">
                        <i class="fas fa-code"></i>
                    </div>
                    <div class="resource-info">
                        <h4>Python for Data Analysis</h4>
                        <p>Pandas & NumPy essentials</p>
                    </div>
                </div>
                <div class="resource-card">
                    <div class="resource-icon quiz">
                        <i class="fas fa-tasks"></i>
                    </div>
                    <div class="resource-info">
                        <h4>Digital Marketing Assessment</h4>
                        <p>Test your SEO knowledge</p>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="activities">
            <h3>Recent Activities</h3>
            <div class="activity-item">
                <div class="activity-icon blue">
                    <i class="fas fa-project-diagram"></i>
                </div>
                <div class="activity-info">
                    <h4>Ray shared a new project</h4>
                    <p>Web Development Portfolio with interactive elements</p>
                </div>
                <div class="activity-time">2 hours ago</div>
            </div>
            <div class="activity-item">
                <div class="activity-icon green">
                    <i class="fas fa-user-graduate"></i>
                </div>
                <div class="activity-info">
                    <h4>Maxwell completed UX Design course</h4>
                    <p>Added new certification to skill profile</p>
                </div>
                <div class="activity-time">Yesterday</div>
            </div>
        </div>
        
        <div class="button-group">
            <a href="https://meet.jit.si/SkillSwapSession" class="video-call-btn" target="_blank">
                <i class="fas fa-video"></i> Join Learning Session
            </a>
            <a href="#" class="schedule-btn">
                <i class="fas fa-calendar-alt"></i> Schedule Mentor Meeting
            </a>
        </div>
    </div>
</body>
</html>