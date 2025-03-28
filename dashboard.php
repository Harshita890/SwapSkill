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
            background: #f4f6fc;
        }
        .sidebar {
            width: 250px;
            background: #ffffff;
            padding: 20px;
            height: 100vh;
            box-shadow: 2px 0 10px rgba(0, 0, 0, 0.1);
        }
        .sidebar h2 {
            margin-bottom: 30px;
            text-align: center;
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
        }
        .sidebar ul li:hover, .sidebar ul li.active {
            background: #432937;
            color: white;
        }
        .main-content {
            flex: 1;
            padding: 20px;
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
        }
        .stats {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
            margin-bottom: 20px;
        }
        .stat-card {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        .activities {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <h2>SkillSwap</h2>
        <ul>
            <botton><li class="active">Dashboard</li>
            <li>Profile</li>
            <li>Skills</li>
            <li>Messages</li>
            <li>Logout</li></<botton>
        </ul>
    </div>
    <div class="main-content">
        <div class="top-bar">
            <input type="text" placeholder="Search...">
            <span>Welcome, <?php echo $_SESSION['username']; ?></span>
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
    </div>
</body>
</html>