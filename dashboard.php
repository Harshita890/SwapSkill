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
        }
        body {
            display: flex;
            background:url('./assets/images/images.jpg') no-repeat center center;
            background-size: cover;
            min-height: 100vh;
        }
        .sidebar {
            width: 250px;
            background: rgba(255, 255, 255, 0.9);
            padding: 20px;
            height: 100vh;
            box-shadow: 2px 0 10px rgba(0, 0, 0, 0.1);
        }
        .sidebar h2 {
            margin-bottom: 30px;
            text-align: center;
            color: #432937;
        }
        .sidebar ul {
            list-style: none;
        }
        .sidebar ul li {
            padding: 15px;
            margin-bottom: 10px;
            border-radius: 5px;
            cursor: pointer;
            transition: 0.3s;
            color: #333;
        }
        .sidebar ul li:hover, .sidebar ul li.active {
            background: #432937;
            color: white;
        }
        .sidebar ul li a {
            text-decoration: none;
            color: inherit;
            display: block;
        }
        .main-content {
            flex: 1;
            padding: 20px;
            background: rgba(255, 255, 255, 0.85);
            margin: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            height: fit-content;
        }
        .top-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-bottom: 20px;
        }
        .top-bar input {
            padding: 10px;
            width: 300px;
            border: 1px solid #ddd;
            border-radius: 5px;
            background: rgba(255, 255, 255, 0.8);
        }
        .stats {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
            margin-bottom: 20px;
        }
        .stat-card {
            background: rgba(255, 255, 255, 0.95);
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            text-align: center;
            backdrop-filter: blur(5px);
        }
        .activities {
            background: rgba(255, 255, 255, 0.95);
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            margin-top: 20px;
            backdrop-filter: blur(5px);
        }
        .video-call-btn {
            display: inline-block;
            margin-top: 20px;
            padding: 12px 24px;
            background: #432937;
            color: white;
            border-radius: 5px;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s;
            border: none;
            cursor: pointer;
        }
        .video-call-btn:hover {
            background: #5a3a4a;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .welcome-text {
            font-weight: 600;
            color: #432937;
            background: rgba(255, 255, 255, 0.7);
            padding: 5px 10px;
            border-radius: 5px;
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