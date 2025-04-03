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
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
    * {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Poppins', sans-serif;
    transition: all 0.3s ease;
}

body {
    display: flex;
    background: #F5F5DC; /* Beige background */
    background-size: cover;
    min-height: 100vh;
}

body::before {
    content: "";
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: linear-gradient(120deg, rgba(0, 0, 0, 0.3), rgba(75, 0, 130, 0.2));
    z-index: -1;
    animation: gradientShift 15s infinite alternate;
}

@keyframes gradientShift {
    0% {
        background-position: 0% 50%;
    }
    50% {
        background-position: 100% 50%;
    }
    100% {
        background-position: 0% 50%;
    }
}

.sidebar {
    width: 250px;
    background: #000000; /* Black sidebar */
    padding: 20px;
    height: 100vh;
    box-shadow: 2px 0 15px rgba(0, 0, 0, 0.4);
    position: relative;
    z-index: 2;
}

.sidebar h2 {
    margin-bottom: 30px;
    text-align: center;
    color: #FFD700; /* Gold text */
    position: relative;
    padding-bottom: 10px;
}

.sidebar h2::after {
    content: '';
    position: absolute;
    bottom: 0;
    left: 50%;
    transform: translateX(-50%);
    width: 50px;
    height: 3px;
    background: #FFD700; /* Gold underline */
    border-radius: 2px;
}

.sidebar ul {
    list-style: none;
}

.sidebar ul li {
    padding: 15px;
    margin-bottom: 15px;
    border-radius: 8px;
    cursor: pointer;
    transition: 0.3s;
    color: #C0C0C0; /* Silver text */
    position: relative;
    overflow: hidden;
}

.sidebar ul li::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: rgba(255, 215, 0, 0.15); /* Gold with opacity */
    transition: all 0.5s ease;
    z-index: -1;
}

.sidebar ul li:hover::before, .sidebar ul li.active::before {
    left: 0;
}

.sidebar ul li:hover, .sidebar ul li.active {
    background: rgba(1, 50, 32, 0.8); /* Dark Green */
    color: #FFD700; /* Gold text on hover */
    transform: translateX(5px);
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
}

.sidebar ul li a {
    text-decoration: none;
    color: inherit;
    display: block;
}

.main-content {
    flex: 1;
    padding: 30px;
    background: rgba(245, 245, 220, 0.9); /* Beige with opacity */
    margin: 20px;
    border-radius: 15px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
    height: fit-content;
    transition: transform 0.3s, box-shadow 0.3s;
}

.main-content:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 35px rgba(0, 0, 0, 0.2);
}

.top-bar {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding-bottom: 25px;
    border-bottom: 1px solid rgba(1, 50, 32, 0.2); /* Dark Green with opacity */
    margin-bottom: 25px;
}

.top-bar input {
    padding: 12px 20px;
    width: 300px;
    border: 2px solid rgba(1, 50, 32, 0.3); /* Dark Green border */
    border-radius: 8px;
    background: rgba(255, 255, 255, 0.9);
    transition: all 0.3s ease;
}

.top-bar input:focus {
    outline: none;
    border-color: #4B0082; /* Deep Purple */
    box-shadow: 0 0 0 3px rgba(75, 0, 130, 0.2); /* Deep Purple with opacity */
    width: 320px;
}

.stats {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 30px;
    margin-bottom: 30px;
}

.stat-card {
    background: rgba(255, 255, 255, 0.95);
    padding: 25px;
    border-radius: 12px;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
    text-align: center;
    backdrop-filter: blur(5px);
    border-left: 4px solid #4B0082; /* Deep Purple border */
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
}

.stat-card::before {
    content: '';
    position: absolute;
    top: -100%;
    left: 0;
    width: 100%;
    height: 100%;
    background: linear-gradient(rgba(75, 0, 130, 0.1), transparent); /* Deep Purple gradient */
    transition: all 0.5s ease;
}

.stat-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 15px 25px rgba(0, 0, 0, 0.1);
    border-left: 4px solid #FFD700; /* Gold border on hover */
}

.stat-card:hover::before {
    top: 0;
}

.activities {
    background: rgba(255, 255, 255, 0.95);
    padding: 30px;
    border-radius: 12px;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
    margin-top: 30px;
    backdrop-filter: blur(5px);
    border-top: 4px solid #013220; /* Dark Green border */
    transition: all 0.3s ease;
}

.activities:hover {
    box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
}

.video-call-btn {
    display: inline-block;
    margin-top: 25px;
    padding: 14px 28px;
    background: #000000; /* Black button */
    color: #FFD700; /* Gold text */
    border-radius: 8px;
    text-decoration: none;
    font-weight: 500;
    transition: all 0.3s;
    border: none;
    cursor: pointer;
    position: relative;
    overflow: hidden;
    z-index: 1;
}

.video-call-btn::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: #4B0082; /* Deep Purple hover effect */
    transition: all 0.5s ease;
    z-index: -1;
}

.video-call-btn:hover {
    color: #C0C0C0; /* Silver text on hover */
    transform: translateY(-3px);
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.3);
}

.video-call-btn:hover::before {
    left: 0;
}

.welcome-text {
    font-weight: 600;
    color: #013220; /* Dark Green text */
    background: rgba(255, 255, 255, 0.8);
    padding: 10px 15px;
    border-radius: 8px;
    position: relative;
    overflow: hidden;
    display: inline-block;
    margin-bottom: 20px;
    box-shadow: 0 3px 10px rgba(0, 0, 0, 0.1);
    animation: fadeInUp 0.8s ease;
}

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

/* Adding animations for page load */
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

.stat-card:nth-child(1) { 
    animation-delay: 0.1s; 
    border-left: 4px solid #000000; /* Black border */
}
.stat-card:nth-child(2) { 
    animation-delay: 0.3s; 
    border-left: 4px solid #4B0082; /* Deep Purple border */
}
.stat-card:nth-child(3) { 
    animation-delay: 0.5s; 
    border-left: 4px solid #013220; /* Dark Green border */
}

.stat-card:nth-child(1):hover {
    border-left: 4px solid #FFD700; /* Gold border on hover */
}
.stat-card:nth-child(2):hover {
    border-left: 4px solid #C0C0C0; /* Silver border on hover */
}
.stat-card:nth-child(3):hover {
    border-left: 4px solid #F5F5DC; /* Beige border on hover */
}

.stat-card {
    animation: fadeIn 0.8s ease forwards;
    opacity: 0;
}

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
    
    </style>
</head>
<body>
    <div class="sidebar">
        <h2>SkillSwap</h2>
        <ul>
            <li class="active"><a href="dashboard.php">Dashboard</a></li>
            <li><a href="profile.php">Profile</a></li>
            <li><a href="skills.php">Skills</a></li>
            <li><a href="messages.php">Messages</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </div>
    <div class="main-content">
        <div class="top-bar">
            <input type="text" placeholder="Search...">
            <span class="welcome-text">Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?></span>
        </div>
        <div class="stats">
            <div class="stat-card">
                <h3>19,089</h3>
                <p>Month Visits</p>
            </div>
            <div class="stat-card">
                <h3>7,735</h3>
                <p>Month Likes</p>
            </div>
            <div class="stat-card">
                <h3>1,826</h3>
                <p>Month Comments</p>
            </div>
        </div>
        <div class="activities">
            <h3>Recent Activities</h3>
            <p>Ray released a new project</p>
            <p>Maxwell joined the team</p>
        </div>
        <a href="https://meet.jit.si/SkillSwapSession" class="video-call-btn" target="_blank">Join Video Call Session</a>
    </div>
</body>
</html>
