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
    <title>SkillSwap - Profile</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        /* Same styles as dashboard.php */
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
        .profile-card {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            margin: 0 auto;
        }
        .profile-header {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
        }
        .profile-pic {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            background: #ddd;
            margin-right: 20px;
            overflow: hidden;
        }
        .profile-pic img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .profile-info h2 {
            margin-bottom: 5px;
        }
        .profile-details {
            margin-top: 20px;
        }
        .profile-details div {
            margin-bottom: 15px;
        }
        .profile-details label {
            display: block;
            font-weight: 600;
            margin-bottom: 5px;
        }
        .profile-details input, .profile-details textarea {
            width: 100%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        .save-btn {
            background: #432937;
            color: white;
            border: none;
            padding: 10px 20px;
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
            <li class="active"><a href="profile.php">Profile</a></li>
            <li><a href="skills.php">Skills</a></li>
            <li><a href="messages.php">Messages</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </div>
    <div class="main-content">
        <div class="profile-card">
            <div class="profile-header">
                <div class="profile-pic">
                    <img src="https://via.placeholder.com/100" alt="Profile Picture">
                </div>
                <div class="profile-info">
                    <h2><?php echo htmlspecialchars($_SESSION['username']); ?></h2>
                    <p>Member since <?php echo date("Y"); ?></p>
                </div>
            </div>
            <div class="profile-details">
                <div>
                    <label for="bio">Bio</label>
                    <textarea id="bio" rows="4">I'm passionate about learning and sharing skills!</textarea>
                </div>
                <div>
                    <label for="skills">Skills</label>
                    <input type="text" id="skills" value="Web Development, Graphic Design">
                </div>
                <div>
                    <label for="location">Location</label>
                    <input type="text" id="location" value="New York, USA">
                </div>
                <button class="save-btn">Save Changes</button>
            </div>
        </div>
    </div>
</body>
</html>