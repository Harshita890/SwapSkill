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
    <title>SkillSwap - Skills</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        /* Same base styles as dashboard.php */
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
        .sidebar ul li a {
            text-decoration: none;
            color: inherit;
            display: block;
        }
        .main-content {
            flex: 1;
            padding: 20px;
        }
        .skills-container {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        .skills-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }
        .add-skill-btn {
            background: #432937;
            color: white;
            border: none;
            padding: 8px 15px;
            border-radius: 5px;
            cursor: pointer;
        }
        .skills-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 20px;
        }
        .skill-card {
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 15px;
            transition: transform 0.3s;
        }
        .skill-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }
        .skill-card h3 {
            margin-bottom: 10px;
        }
        .skill-card p {
            color: #666;
            margin-bottom: 15px;
        }
        .skill-level {
            height: 5px;
            background: #eee;
            border-radius: 5px;
            margin-bottom: 10px;
        }
        .skill-level-fill {
            height: 100%;
            background: #432937;
            border-radius: 5px;
            width: 75%; /* Adjust based on skill level */
        }
        .skill-actions {
            display: flex;
            justify-content: space-between;
        }
        .skill-actions button {
            background: none;
            border: 1px solid #432937;
            color: #432937;
            padding: 5px 10px;
            border-radius: 5px;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <h2>SkillSwap</h2>
        <ul>
            <li><a href="dashboard.php">Dashboard</a></li>
            <li><a href="profile.php">Profile</a></li>
            <li class="active"><a href="skills.php">Skills</a></li>
            <li><a href="messages.php">Messages</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </div>
    <div class="main-content">
        <div class="skills-container">
            <div class="skills-header">
                <h2>My Skills</h2>
                <button class="add-skill-btn">+ Add Skill</button>
            </div>
            <div class="skills-grid">
                <div class="skill-card">
                    <h3>Web Development</h3>
                    <p>HTML, CSS, JavaScript, PHP</p>
                    <div class="skill-level">
                        <div class="skill-level-fill" style="width: 85%"></div>
                    </div>
                    <div class="skill-actions">
                        <button>Edit</button>
                        <button>Share</button>
                    </div>
                </div>
                <div class="skill-card">
                    <h3>Graphic Design</h3>
                    <p>Photoshop, Illustrator</p>
                    <div class="skill-level">
                        <div class="skill-level-fill" style="width: 70%"></div>
                    </div>
                    <div class="skill-actions">
                        <button>Edit</button>
                        <button>Share</button>
                    </div>
                </div>
                <div class="skill-card">
                    <h3>Video Editing</h3>
                    <p>Premiere Pro, After Effects</p>
                    <div class="skill-level">
                        <div class="skill-level-fill" style="width: 60%"></div>
                    </div>
                    <div class="skill-actions">
                        <button>Edit</button>
                        <button>Share</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>