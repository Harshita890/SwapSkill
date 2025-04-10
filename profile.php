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
$error = $success = '';

$conn->query("CREATE TABLE IF NOT EXISTS user_profiles (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    bio TEXT,
    skills VARCHAR(255),
    location VARCHAR(255),
    FOREIGN KEY (user_id) REFERENCES users(id)
)");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $bio = $conn->real_escape_string($_POST['bio'] ?? '');
    $skills = $conn->real_escape_string($_POST['skills'] ?? '');
    $location = $conn->real_escape_string($_POST['location'] ?? '');
    
    $check = $conn->query("SELECT id FROM user_profiles WHERE user_id = $user_id");
    
    if ($check->num_rows > 0) {
        $sql = "UPDATE user_profiles SET bio='$bio', skills='$skills', location='$location' WHERE user_id=$user_id";
    } else {
        $sql = "INSERT INTO user_profiles (user_id, bio, skills, location) VALUES ($user_id, '$bio', '$skills', '$location')";
    }
    
    if ($conn->query($sql)) {
        $success = "Profile updated successfully!";
    } else {
        $error = "Error updating profile: " . $conn->error;
    }
}

$profile = ['bio' => '', 'skills' => '', 'location' => ''];
$result = $conn->query("SELECT bio, skills, location FROM user_profiles WHERE user_id = $user_id");
if ($result && $result->num_rows > 0) {
    $profile = $result->fetch_assoc();
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SkillSwap - Profile</title>
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

    /* Profile Form Styles */
    .profile-container {
        background: var(--card-bg);
        padding: 30px;
        border-radius: 16px;
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
        margin-bottom: 35px;
        position: relative;
        border-left: 4px solid var(--primary);
        color: var(--text-dark);
    }

    .profile-container h1 {
        font-size: 28px;
        margin-bottom: 25px;
        color: var(--text-dark);
        position: relative;
        padding-left: 15px;
    }

    .profile-container h1::before {
        content: '';
        position: absolute;
        left: 0;
        top: 50%;
        transform: translateY(-50%);
        width: 5px;
        height: 30px;
        background: var(--primary);
        border-radius: 5px;
    }

    .form-group {
        margin-bottom: 25px;
    }

    .form-group label {
        display: block;
        margin-bottom: 10px;
        font-weight: 600;
        color: var(--text-dark);
    }

    .form-group input, 
    .form-group textarea, 
    .form-group select {
        width: 100%;
        padding: 14px 20px;
        border: 2px solid #e0e0e0;
        border-radius: 10px;
        font-size: 16px;
        transition: all 0.3s;
        background-color: var(--yellow-light);
    }

    .form-group textarea {
        height: 150px;
        resize: vertical;
    }

    .form-group input:focus, 
    .form-group textarea:focus, 
    .form-group select:focus {
        outline: none;
        border-color: var(--primary);
        box-shadow: 0 0 0 5px rgba(255, 209, 0, 0.2);
    }

    button[type="submit"] {
        background: var(--primary);
        color: var(--text-dark);
        border: none;
        padding: 14px 28px;
        border-radius: 50px;
        font-weight: 600;
        font-size: 16px;
        cursor: pointer;
        transition: all 0.3s;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 8px 15px rgba(255, 209, 0, 0.3);
    }

    button[type="submit"]:hover {
        background: var(--yellow-dark);
        transform: translateY(-3px);
        box-shadow: 0 12px 20px rgba(255, 209, 0, 0.4);
    }

    .error {
        color: #e74c3c;
        background: #fdecea;
        padding: 15px;
        border-radius: 10px;
        margin-bottom: 25px;
        border-left: 4px solid #e74c3c;
        animation: fadeIn 0.5s ease;
    }

    .success {
        color: #2ecc71;
        background: #e8f8f0;
        padding: 15px;
        border-radius: 10px;
        margin-bottom: 25px;
        border-left: 4px solid #2ecc71;
        animation: fadeIn 0.5s ease;
    }

    .dashboard-box {
        text-align: center;
        margin-top: 30px;
    }

    .dashboard-box a {
        display: inline-block;
        padding: 14px 28px;
        background: var(--secondary);
        color: white;
        text-decoration: none;
        border-radius: 50px;
        font-weight: 600;
        transition: all 0.3s;
        box-shadow: 0 8px 15px rgba(50, 205, 50, 0.3);
    }

    .dashboard-box a:hover {
        background: var(--green-dark);
        transform: translateY(-3px);
        box-shadow: 0 12px 20px rgba(50, 205, 50, 0.4);
    }

    .dashboard-box a i {
        margin-right: 10px;
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

    /* Responsive adjustments */
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
        
        .top-bar {
            flex-direction: column;
            gap: 20px;
        }
        
        .search-container {
            width: 100%;
        }
        
        .search-container input:focus {
            width: 100%;
        }
    }
    </style>
</head>
<body>
    <div class="sidebar">
        <h2>SkillSwap</h2>
        <ul>
            <li><a href="dashboard.php"><i class="fas fa-chart-line"></i> Dashboard</a></li>
            <li class="active"><a href="profile.php"><i class="fas fa-user"></i> Profile</a></li>
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
        
        <div class="profile-container">
            <h1>My Profile</h1>
            
            <?php if ($error): ?>
                <div class="error"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>
            
            <?php if ($success): ?>
                <div class="success"><?= htmlspecialchars($success) ?></div>
            <?php endif; ?>
            
            <form method="post">
                <div class="form-group">
                    <label>Bio:</label>
                    <textarea name="bio"><?= htmlspecialchars($profile['bio']) ?></textarea>
                </div>
                
                <div class="form-group">
                    <label>Skills (comma separated):</label>
                    <input type="text" name="skills" value="<?= htmlspecialchars($profile['skills']) ?>">
                </div>
                
                <div class="form-group">
                    <label>Location:</label>
                    <input type="text" name="location" value="<?= htmlspecialchars($profile['location']) ?>">
                </div>
                
                <button type="submit"><i class="fas fa-save"></i> Save Profile</button>
            </form>
            
            <div class="dashboard-box">
                <a href="dashboard.php"><i class="fas fa-arrow-left"></i> Back to Dashboard</a>
            </div>
        </div>
    </div>
</body>
</html>