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
    <style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: 'Nunito', sans-serif;
        transition: all 0.3s ease;
    }

    :root {
        --primary: #ffd100;      /* Bright yellow */
        --secondary: #32cd32;    /* Lime green */
        --accent1: #ffb700;      /* Golden yellow */
        --accent2: #7cb342;      /* Medium green */
        --bg-light: #fffdf2;     /* Very light yellow tint */
        --sidebar: #222222;      /* Dark black for sidebar */
        --text-dark: #333333;    /* Dark text */
        --text-light: #FFFFFF;   /* White text */
        --card-bg: #FFFFFF;      /* White card background */
        
        /* Additional colors */
        --yellow-dark: #e6b800;  /* Darker yellow */
        --green-dark: #2e8b57;   /* Dark green */
        --yellow-light: #fff8e1; /* Very light yellow */
        --green-light: #e8f5e9;  /* Very light green */
        --gradient1: #ffd100;    /* Yellow gradient */
        --gradient2: #7cb342;    /* Green gradient */
    }

    body {
        display: flex;
        background: var(--bg-light);
        min-height: 100vh;
        position: relative;
        overflow-x: hidden;
    }

    body::before {
        content: "";
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: url("data:image/svg+xml,%3Csvg width='100' height='100' viewBox='0 0 100 100' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M11 18c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm48 25c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm-43-7c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm63 31c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM34 90c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm56-76c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM12 86c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm28-65c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm23-11c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-6 60c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm29 22c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zM32 63c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm57-13c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-9-21c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM60 91c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM35 41c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM12 60c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2z' fill='%23ffd100' fill-opacity='0.05' fill-rule='evenodd'/%3E%3C/svg%3E");
        z-index: -1;
    }

    .sidebar {
        width: 280px;
        background: var(--sidebar);
        padding: 25px;
        height: 100vh;
        box-shadow: 5px 0 15px rgba(0, 0, 0, 0.2);
        position: sticky;
        top: 0;
        z-index: 10;
        background-image: linear-gradient(to bottom, #222222, #333333);
    }

    .sidebar h2 {
        margin-bottom: 35px;
        text-align: center;
        color: var(--primary);
        font-weight: 700;
        font-size: 28px;
        position: relative;
        padding-bottom: 15px;
        letter-spacing: 1px;
    }

    .sidebar h2::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 50%;
        transform: translateX(-50%);
        width: 60px;
        height: 4px;
        background: var(--secondary);
        border-radius: 10px;
    }

    .sidebar ul {
        list-style: none;
    }

    .sidebar ul li {
        padding: 15px 20px;
        margin-bottom: 18px;
        border-radius: 10px;
        cursor: pointer;
        transition: all 0.4s ease;
        color: var(--text-light);
        position: relative;
        overflow: hidden;
        display: flex;
        align-items: center;
    }

    .sidebar ul li i {
        margin-right: 12px;
        font-size: 18px;
        width: 22px;
        text-align: center;
    }

    .sidebar ul li::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: rgba(255, 255, 255, 0.1);
        transition: all 0.5s ease;
        z-index: -1;
    }

    .sidebar ul li:hover::before, .sidebar ul li.active::before {
        left: 0;
    }

    .sidebar ul li:hover, .sidebar ul li.active {
        background: rgba(255, 255, 255, 0.15);
        color: var(--primary);
        transform: translateX(8px);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
    }

    .sidebar ul li a {
        text-decoration: none;
        color: inherit;
        display: flex;
        align-items: center;
        width: 100%;
    }

    .main-content {
        flex: 1;
        padding: 30px 40px;
        background: linear-gradient(135deg, #222222, #333333);
        margin: 25px;
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        height: calc(100vh - 50px);
        overflow-y: auto;
        transition: transform 0.3s, box-shadow 0.3s;
        color: var(--text-light);
    }

    .main-content:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.25);
    }

    .top-bar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding-bottom: 25px;
        border-bottom: 1px solid rgba(255, 255, 255, 0.2);
        margin-bottom: 30px;
    }

    .search-container {
        position: relative;
        width: 350px;
    }

    .search-container input {
        padding: 14px 20px;
        padding-left: 45px;
        width: 100%;
        border: 2px solid rgba(255, 255, 255, 0.2);
        border-radius: 50px;
        background: rgba(255, 255, 255, 0.15);
        font-size: 15px;
        transition: all 0.3s ease;
        color: var(--text-light);
    }

    .search-container input::placeholder {
        color: rgba(255, 255, 255, 0.7);
    }

    .search-container i {
        position: absolute;
        left: 15px;
        top: 50%;
        transform: translateY(-50%);
        color: rgba(255, 255, 255, 0.7);
        font-size: 18px;
    }

    .search-container input:focus {
        outline: none;
        border-color: var(--primary);
        background: rgba(255, 255, 255, 0.2);
        box-shadow: 0 0 0 5px rgba(255, 209, 0, 0.2);
        width: 110%;
    }

    .welcome-text {
        font-weight: 600;
        color: var(--text-light);
        background: rgba(50, 205, 50, 0.2);
        padding: 12px 20px;
        border-radius: 50px;
        position: relative;
        overflow: hidden;
        display: inline-block;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        animation: fadeInUp 0.8s ease;
    }

    .welcome-text span {
        color: var(--primary);
        font-weight: 700;
    }

    .stats {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 30px;
        margin-bottom: 35px;
    }

    .stat-card {
        background: var(--card-bg);
        padding: 25px;
        border-radius: 16px;
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
        text-align: center;
        position: relative;
        overflow: hidden;
        transition: all 0.4s ease;
        border-bottom: 4px solid transparent;
    }

    .stat-card::before {
        content: '';
        position: absolute;
        top: -100%;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(135deg, rgba(255, 209, 0, 0.1), transparent);
        transition: all 0.5s ease;
    }

    .stat-card h3 {
        font-size: 32px;
        font-weight: 700;
        margin-bottom: 8px;
        color: var(--text-dark);
    }

    .stat-card p {
        color: #777;
        font-size: 16px;
    }

    .stat-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 15px 30px rgba(0, 0, 0, 0.2);
    }

    .stat-card:hover::before {
        top: 0;
    }

    .stat-card:nth-child(1) {
        border-bottom: 4px solid var(--primary);
    }

    .stat-card:nth-child(2) {
        border-bottom: 4px solid var(--secondary);
    }

    .stat-card:nth-child(3) {
        border-bottom: 4px solid var(--accent1);
    }

    .stat-card .icon {
        height: 60px;
        width: 60px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 15px;
        font-size: 24px;
        color: var(--text-light);
    }

    .stat-card:nth-child(1) .icon {
        background: var(--primary);
    }

    .stat-card:nth-child(2) .icon {
        background: var(--secondary);
    }

    .stat-card:nth-child(3) .icon {
        background: var(--accent1);
    }

    .activities {
        background: var(--card-bg);
        padding: 30px;
        border-radius: 16px;
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
        margin-top: 35px;
        position: relative;
        border-left: 4px solid var(--accent1);
        color: var(--text-dark);
    }

    .activities h3 {
        font-size: 22px;
        font-weight: 600;
        color: var(--text-dark);
        margin-bottom: 20px;
        position: relative;
        padding-left: 15px;
    }

    .activities h3::before {
        content: '';
        position: absolute;
        left: 0;
        top: 50%;
        transform: translateY(-50%);
        width: 5px;
        height: 25px;
        background: var(--accent1);
        border-radius: 5px;
    }

    .activity-item {
        display: flex;
        align-items: center;
        padding: 15px;
        margin-bottom: 15px;
        background: var(--yellow-light);
        border-radius: 10px;
        transition: all 0.3s;
    }

    .activity-item:hover {
        background: var(--green-light);
        transform: translateX(5px);
    }

    .activity-item:last-child {
        margin-bottom: 0;
    }

    .activity-icon {
        width: 45px;
        height: 45px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 15px;
        font-size: 18px;
        color: white;
    }

    .activity-icon.blue {
        background: var(--primary);
    }

    .activity-icon.green {
        background: var(--secondary);
    }

    .activity-info {
        flex: 1;
    }

    .activity-info h4 {
        font-size: 16px;
        font-weight: 600;
        color: var(--text-dark);
        margin-bottom: 5px;
    }

    .activity-info p {
        font-size: 14px;
        color: #777;
    }

    .activity-time {
        background: #eeeeee;
        padding: 5px 10px;
        border-radius: 20px;
        font-size: 12px;
        color: #666;
        font-weight: 500;
    }

    .button-group {
        display: flex;
        gap: 20px;
        margin-top: 35px;
    }

    .video-call-btn {
        padding: 14px 28px;
        background: var(--secondary);
        color: white;
        border-radius: 50px;
        text-decoration: none;
        font-weight: 600;
        transition: all 0.3s;
        border: none;
        cursor: pointer;
        position: relative;
        overflow: hidden;
        z-index: 1;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 16px;
        box-shadow: 0 8px 15px rgba(50, 205, 50, 0.3);
    }

    .video-call-btn i {
        margin-right: 10px;
    }

    .video-call-btn::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, rgba(0,0,0,0.1), transparent);
        transition: all 0.5s ease;
        z-index: -1;
    }

    .video-call-btn:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 20px rgba(50, 205, 50, 0.4);
    }

    .video-call-btn:hover::before {
        left: 100%;
    }

    .schedule-btn {
        padding: 14px 28px;
        background: rgba(255, 255, 255, 0.9);
        color: var(--sidebar);
        border: 2px solid var(--primary);
        border-radius: 50px;
        text-decoration: none;
        font-weight: 600;
        transition: all 0.3s;
        cursor: pointer;
        position: relative;
        overflow: hidden;
        z-index: 1;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 16px;
    }

    .schedule-btn i {
        margin-right: 10px;
    }

    .schedule-btn:hover {
        background: var(--primary);
        color: var(--sidebar);
        transform: translateY(-5px);
        box-shadow: 0 8px 15px rgba(255, 209, 0, 0.3);
    }

    /* Learning Resources Section */
    .learning-resources {
        background: var(--card-bg);
        padding: 30px;
        border-radius: 16px;
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
        margin-top: 35px;
        position: relative;
        border-left: 4px solid var(--secondary);
        color: var(--text-dark);
    }

    .learning-resources h3 {
        font-size: 22px;
        font-weight: 600;
        color: var(--text-dark);
        margin-bottom: 20px;
        position: relative;
        padding-left: 15px;
    }

    .learning-resources h3::before {
        content: '';
        position: absolute;
        left: 0;
        top: 50%;
        transform: translateY(-50%);
        width: 5px;
        height: 25px;
        background: var(--secondary);
        border-radius: 5px;
    }

    .resource-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 20px;
    }

    .resource-card {
        background: var(--yellow-light);
        border-radius: 10px;
        padding: 15px;
        display: flex;
        align-items: center;
        transition: all 0.3s;
    }

    .resource-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        background: var(--green-light);
    }

    .resource-icon {
        width: 50px;
        height: 50px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 15px;
        font-size: 20px;
        color: white;
    }

    .resource-icon.book {
        background: linear-gradient(135deg, #ffd100, #ffb700);
    }

    .resource-icon.video {
        background: linear-gradient(135deg, #32cd32, #2e8b57);
    }

    .resource-icon.code {
        background: linear-gradient(135deg, #222222, #333333);
    }

    .resource-icon.quiz {
        background: linear-gradient(135deg, #7cb342, #32cd32);
    }

    .resource-info h4 {
        font-size: 16px;
        font-weight: 600;
        color: var(--text-dark);
        margin-bottom: 5px;
    }

    .resource-info p {
        font-size: 13px;
        color: #777;
    }

    /* Animations */
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .sidebar, .main-content {
        animation: slideIn 0.8s ease;
    }

    @keyframes slideIn {
        from {
            opacity: 0;
            transform: translateX(-30px);
        }
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    .stat-card {
        animation: fadeIn 0.8s ease forwards;
        opacity: 0;
    }

    .stat-card:nth-child(1) { animation-delay: 0.1s; }
    .stat-card:nth-child(2) { animation-delay: 0.3s; }
    .stat-card:nth-child(3) { animation-delay: 0.5s; }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .activities, .learning-resources {
        animation: fadeIn 0.8s ease forwards;
        animation-delay: 0.7s;
        opacity: 0;
    }

    /* Responsive adjustments */
    @media (max-width: 1200px) {
        .stats {
            grid-template-columns: repeat(2, 1fr);
        }
        .resource-grid {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 992px) {
        .sidebar {
            width: 220px;
            padding: 20px;
        }
        
        .main-content {
            margin: 20px;
            padding: 25px;
        }
    }

    @media (max-width: 768px) {
        body {
            flex-direction: column;
        }
        
        .sidebar {
            width: 100%;
            height: auto;
            padding: 15px;
        }
        
        .sidebar ul {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 10px;
        }
        
        .sidebar ul li {
            margin: 0;
            padding: 12px 15px;
        }
        
        .main-content {
            margin: 10px;
            height: auto;
        }
        
        .stats {
            grid-template-columns: 1fr;
        }
        
        .button-group {
            flex-direction: column;
        }
    }
    </style>
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