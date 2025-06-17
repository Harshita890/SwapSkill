<?php
session_start();

$db_host = 'localhost';
$db_user = 'root';
$db_pass = '';
$db_name = 'skillswap';

$conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$isPremium = false;

$result = $conn->query("SELECT is_premium FROM users WHERE id = $user_id");
if ($result && $result->num_rows > 0) {
    $user = $result->fetch_assoc();
    $isPremium = $user['is_premium'];
}

$query = "SELECT s.*, u.username as creator FROM skills s JOIN users u ON s.user_id = u.id";
$result = $conn->query($query);

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>SkillSwap - Skills</title>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="css.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Nunito', sans-serif;
            transition: all 0.3s ease;
        }

        :root {
            --primary: #ffd100;     
            --secondary: #32cd32;    
            --accent1: #ffb700;     
            --accent2: #7cb342;      
            --bg-light: #fffdf2;     
            --sidebar: #222222;      
            --text-dark: #333333;    
            --text-light: #FFFFFF;   
            --card-bg: #FFFFFF;      
            --yellow-dark: #e6b800;  
            --green-dark: #2e8b57;   
            --yellow-light: #fff8e1; 
            --green-light: #e8f5e9;  
        }

        body {
            display: flex;
            background: var(--bg-light);
            min-height: 100vh;
        }

        .sidebar {
            width: 250px;
            background: var(--sidebar);
            color: var(--text-light);
            padding: 20px;
            height: 100vh;
            position: fixed;
        }

        .sidebar h2 {
            color: var(--primary);
            margin-bottom: 30px;
            text-align: center;
        }

        .sidebar ul {
            list-style: none;
        }

        .sidebar li {
            margin-bottom: 15px;
        }

        .sidebar a {
            color: var(--text-light);
            text-decoration: none;
            display: flex;
            align-items: center;
            padding: 10px;
            border-radius: 5px;
            transition: all 0.3s;
        }

        .sidebar a:hover {
            background: rgba(255, 255, 255, 0.1);
        }

        .sidebar a i {
            margin-right: 10px;
            width: 20px;
            text-align: center;
        }

        .sidebar .active a {
            background: var(--primary);
            color: var(--text-dark);
            font-weight: 600;
        }

        .main-content {
            flex: 1;
            padding: 30px 40px;
            margin-left: 250px;
            width: calc(100% - 250px);
        }

        .top-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-bottom: 25px;
            border-bottom: 1px solid rgba(0, 0, 0, 0.1);
            margin-bottom: 30px;
        }

        .search-container {
            position: relative;
            width: 300px;
        }

        .search-container i {
            position: absolute;
            left: 10px;
            top: 50%;
            transform: translateY(-50%);
            color: #777;
        }

        .search-container input {
            width: 100%;
            padding: 10px 15px 10px 35px;
            border: 1px solid #ddd;
            border-radius: 50px;
            font-size: 14px;
        }

        .welcome-text {
            font-weight: 600;
            color: var(--text-dark);
            background: rgba(50, 205, 50, 0.2);
            padding: 12px 20px;
            border-radius: 50px;
            position: relative;
            overflow: hidden;
            display: inline-block;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .welcome-text span {
            color: var(--primary);
            font-weight: 700;
        }

        .skills-section {
            background: var(--card-bg);
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
            margin-bottom: 30px;
            border-left: 4px solid var(--primary);
        }

        .skills-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
        }

        .skills-header h2 {
            font-size: 24px;
            font-weight: 600;
            color: var(--text-dark);
            position: relative;
            padding-left: 15px;
        }

        .skills-header h2::before {
            content: '';
            position: absolute;
            left: 0;
            top: 50%;
            transform: translateY(-50%);
            width: 5px;
            height: 25px;
            background: var(--primary);
            border-radius: 5px;
        }

        .add-skill-btn {
            background: var(--secondary);
            color: white;
            text-decoration: none;
            padding: 10px 20px;
            border-radius: 50px;
            font-weight: 600;
            transition: all 0.3s;
            display: inline-flex;
            align-items: center;
        }

        .add-skill-btn:hover {
            background: var(--green-dark);
            transform: translateY(-3px);
            box-shadow: 0 8px 15px rgba(50, 205, 50, 0.3);
        }

        .add-skill-btn i {
            margin-right: 8px;
        }

        .skills-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 20px;
        }

        .skill-card {
            background: var(--yellow-light);
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            transition: all 0.3s;
            position: relative;
            animation: fadeIn 0.8s ease forwards;
            opacity: 0;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .skill-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
            background: var(--green-light);
        }

        .skill-card h3 {
            font-size: 20px;
            margin-bottom: 10px;
            color: var(--text-dark);
        }

        .skill-card p {
            color: #777;
            margin-bottom: 15px;
            font-size: 14px;
        }

        .skill-creator {
            font-size: 12px;
            color: #999;
            margin-bottom: 15px;
            font-style: italic;
        }

        .skill-creator a {
            color: var(--secondary);
            text-decoration: none;
            transition: all 0.3s;
        }

        .skill-creator a:hover {
            color: var(--green-dark);
            text-decoration: underline;
        }

        .skill-actions {
            display: flex;
            gap: 10px;
            margin-top: 20px;
            flex-wrap: wrap;
        }

        .skill-actions a {
            text-decoration: none;
            padding: 10px 15px;
            border-radius: 50px;
            font-weight: 600;
            font-size: 14px;
            transition: all 0.3s;
            display: inline-flex;
            align-items: center;
            white-space: nowrap;
        }

        .skill-actions a:first-child {
            background: var(--secondary);
            color: white;
            box-shadow: 0 5px 15px rgba(50, 205, 50, 0.3);
        }

        .skill-actions a:first-child:hover {
            background: var(--green-dark);
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(50, 205, 50, 0.4);
        }

        .skill-actions a.video-call-btn {
            background: var(--primary);
            color: var(--text-dark);
            box-shadow: 0 5px 15px rgba(255, 209, 0, 0.3);
        }

        .skill-actions a.video-call-btn:hover {
            background: var(--yellow-dark);
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(255, 209, 0, 0.4);
        }

        .skill-actions a.jitsi-btn {
            background: #5b6ee1;
            color: white;
            box-shadow: 0 5px 15px rgba(91, 110, 225, 0.3);
        }

        .skill-actions a.jitsi-btn:hover {
            background: #3a4fc8;
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(91, 110, 225, 0.4);
        }

        .premium-lock {
            position: relative;
            padding-right: 35px !important;
        }

        .premium-lock:after {
            content: "🔒";
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
        }

        @media (max-width: 1200px) {
            .skills-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 768px) {
            .sidebar {
                width: 100%;
                height: auto;
                position: relative;
                padding: 15px;
            }
            
            .main-content {
                margin-left: 0;
                width: 100%;
                padding: 20px;
            }
            
            .skills-grid {
                grid-template-columns: 1fr;
            }
            
            .top-bar {
                flex-direction: column;
                gap: 15px;
                align-items: flex-start;
            }
        }

        @media (max-width: 480px) {
            .skill-actions {
                flex-direction: column;
            }
            
            .skill-actions a {
                width: 100%;
                justify-content: center;
            }
        }
    </style>
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
                <input type="text" placeholder="Search for skills...">
            </div>
            <div class="welcome-text">
                Welcome, <span><?php echo htmlspecialchars($_SESSION['username']); ?></span>
            </div>
        </div>

        <div class="skills-section">
            <div class="skills-header">
                <h2>Available Skills</h2>
                <a href="add_skill.php" class="add-skill-btn"><i class="fas fa-plus"></i> Add Skill</a>
            </div>

            <div class="skills-grid">
                <?php while($row = $result->fetch_assoc()): 
                    $jitsiRoom = "SkillSession_" . $row['id'] . "_" . $row['user_id'];
                    $jitsiLink = "https://meet.jit.si/" . urlencode($jitsiRoom);
                ?>
                    <div class="skill-card" style="animation-delay: <?php echo (rand(1, 5) * 0.1); ?>s">
                        <h3><?php echo htmlspecialchars($row['skill_name']); ?></h3>
                        <p><?php echo htmlspecialchars($row['description']); ?></p>
                        <div class="skill-creator">Posted by: <a href="profile_view.php?user_id=<?php echo $row['user_id']; ?>"><?php echo htmlspecialchars($row['creator']); ?></a></div>
                        <div class="skill-actions">
                            <?php if($isPremium): ?>
                                <a href="<?php echo htmlspecialchars($row['video_link']); ?>" target="_blank"><i class="fas fa-video"></i> Watch Video</a>
                            <?php else: ?>
                                <a href="upgrade.php" class="premium-lock"><i class="fas fa-video"></i> Watch Video</a>
                            <?php endif; ?>
                            
                            <a href="<?php echo $jitsiLink; ?>" target="_blank" class="jitsi-btn"><i class="fas fa-video"></i> Live Session</a>
                            
                            <?php if($row['user_id'] == $user_id): ?>
                                <a href="edit_skill.php?id=<?php echo $row['id']; ?>" class="video-call-btn"><i class="fas fa-edit"></i> Edit</a>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        </div>
    </div>
</body>
</html>