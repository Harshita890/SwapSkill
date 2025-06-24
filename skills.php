<?php
session_start();
require("include/db.php");

if(!isset($_SESSION['username'])){
    header("location: login.php");
}

$isPremium = false;
if(isset($_SESSION['user_id'])) {
    $result = mysqli_query($conn, "SELECT is_premium FROM users WHERE id = ".$_SESSION['user_id']);
    $user = mysqli_fetch_assoc($result);
    $isPremium = $user['is_premium'] ?? false;
}

$query = "SELECT s.*, u.username as creator FROM skills s JOIN users u ON s.user_id = u.id";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Skills List</title>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
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

        .top-bar a {
            color: white;
            text-decoration: none;
            padding: 12px 20px;
            border-radius: 50px;
            font-weight: 600;
            transition: all 0.3s;
            margin-left: 15px;
        }

        .top-bar a:first-child {
            background: rgba(255, 255, 255, 0.15);
            border: 2px solid var(--primary);
        }

        .top-bar a:first-child:hover {
            background: var(--primary);
            color: var(--text-dark);
            transform: translateY(-3px);
            box-shadow: 0 8px 15px rgba(255, 209, 0, 0.3);
        }

        .top-bar a:last-child {
            background: var(--secondary);
            box-shadow: 0 8px 15px rgba(50, 205, 50, 0.3);
        }

        .top-bar a:last-child:hover {
            background: var(--green-dark);
            transform: translateY(-3px);
            box-shadow: 0 12px 20px rgba(50, 205, 50, 0.4);
        }

        .skills-section {
            background: var(--card-bg);
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
            margin-bottom: 30px;
            border-left: 4px solid var(--primary);
            color: var(--text-dark);
        }

        .skills-header h2 {
            font-size: 24px;
            font-weight: 600;
            color: var(--text-dark);
            position: relative;
            padding-left: 15px;
            margin-bottom: 25px;
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

        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @media (max-width: 1200px) {
            .skills-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 768px) {
            body { flex-direction: column; }
            .main-content { margin: 10px; height: auto; padding: 20px; }
            .skills-grid { grid-template-columns: 1fr; }
            .top-bar { flex-direction: column; gap: 15px; align-items: flex-start; }
            .top-bar a { margin-left: 0; margin-right: 10px; margin-bottom: 10px; }
        }

        @media (max-width: 480px) {
            .skill-actions { flex-direction: column; }
            .skill-actions a { width: 100%; justify-content: center; }
        }
    </style>
</head>
<body>

<div class="main-content">
    <div class="top-bar">
        <div class="welcome-text">Welcome, <span><?php echo $_SESSION['username']; ?>!</span></div>
        <div>
            <a href="dashboard.php"><i class="fas fa-arrow-left"></i> Back to Dashboard</a>
            <a href="add_skill.php"><i class="fas fa-plus"></i> Add Skill</a>
        </div>
    </div>

    <div class="skills-section">
        <div class="skills-header">
            <h2>Available Skills</h2>
        </div>

        <div class="skills-grid">
            <?php while($row = mysqli_fetch_assoc($result)) { 
                $jitsiRoom = "SkillSession_" . $row['id'] . "_" . $row['user_id'];
                $jitsiLink = "https://meet.jit.si/" . urlencode($jitsiRoom);
            ?>
                <div class="skill-card" style="animation-delay: <?php echo (rand(1, 5) * 0.1); ?>s">
                    <h3><?php echo $row['skill_name']; ?></h3>
                    <p><?php echo $row['description']; ?></p>
                    <div class="skill-creator">Posted by: <a href="view_profile.php?user_id=<?php echo $row['user_id']; ?>"><?php echo htmlspecialchars($row['creator']); ?></a></div>
                    <div class="skill-actions">
                        <?php if($isPremium): ?>
                            <a href="<?php echo $row['video_link']; ?>" target="_blank"><i class="fas fa-video"></i> Watch Video</a>
                        <?php else: ?>
                            <a href="upgrade.php" class="premium-lock"><i class="fas fa-video"></i> Watch Video</a>
                        <?php endif; ?>
                        
                        <a href="<?php echo $jitsiLink; ?>" target="_blank" class="jitsi-btn"><i class="fas fa-video"></i> Live Session</a>
                        
                        <?php if($row['user_id'] == $_SESSION['user_id']): ?>
                            <a href="edit_skill.php?id=<?php echo $row['id']; ?>" class="video-call-btn"><i class="fas fa-edit"></i> Edit</a>
                        <?php endif; ?>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</div>

</body>
</html>
