<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$mysqli = new mysqli("localhost", "root", "", "skillswap");
if ($mysqli->connect_error) {
    die("Database connection failed: " . $mysqli->connect_error);
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
    <style>
        a {
            text-decoration: none;
        }
        .social-media {
            text-align: center;
            padding: 20px;
            margin-top: 20px;
            background-color: #f4f4f4;
        }
        .social-media a {
            font-size: 20px;
            margin: 0 15px;
            color: #333;
            display: inline-block;
        }
        .social-media a:hover {
            color: #0073e6;
        }
        .social-media i {
            margin-right: 8px;
        }
        .resource-icon i {
            color: black;
        }
        .partners-popup {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 20px rgba(0,0,0,0.2);
            z-index: 1000;
            width: 300px;
        }
        .partners-popup h3 {
            margin-top: 0;
            border-bottom: 1px solid #eee;
            padding-bottom: 10px;
        }
        .partner-item {
            padding: 8px 0;
            border-bottom: 1px solid #f5f5f5;
        }
        .partner-item:last-child {
            border-bottom: none;
        }
        .overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.5);
            z-index: 999;
        }
        .close-btn {
            float: right;
            cursor: pointer;
            font-size: 20px;
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
                <h3>0</h3>
                <p>Lessons Completed</p>
            </div>
            <div class="stat-card">
                <div class="icon"><i class="fas fa-certificate"></i></div>
                <h3>0</h3>
                <p>Skills Achieved</p>
            </div>
            <div class="stat-card" id="partners-stat">
                <div class="icon"><i class="fas fa-users"></i></div>
                <h3>5</h3>
                <p>Learning Partners</p>
            </div>
        </div>

        <div class="learning-resources">
            <h3>Learning Resources</h3>
            <div class="resource-grid">
                <?php
                $res_query = "SELECT * FROM learning_resources";
                $res_result = $mysqli->query($res_query);

                if ($res_result && $res_result->num_rows > 0):
                    while ($res = $res_result->fetch_assoc()):
                ?>
                    <a href="<?php echo htmlspecialchars($res['url']); ?>" class="resource-card" target="_blank">
                        <div class="resource-icon <?php echo htmlspecialchars($res['icon_class']); ?>">
                            <i class="fas fa-book"></i>
                        </div>
                        <div class="resource-info">
                            <h4><?php echo htmlspecialchars($res['title']); ?></h4>
                            <p><?php echo htmlspecialchars($res['description']); ?></p>
                        </div>
                    </a>
                <?php
                    endwhile;
                else:
                    echo "<p>No resources available.</p>";
                endif;
                ?>
            </div>
        </div>

        <div class="activities">
            <h3>Recent Activities</h3>
            <?php
            $userId = $_SESSION['user_id'];
            $sql = "SELECT activity_title, description, activity_time FROM learning_history WHERE user_id = ? ORDER BY activity_time DESC LIMIT 5";
            $stmt = $mysqli->prepare($sql);
            $stmt->bind_param("i", $userId);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0):
                while ($row = $result->fetch_assoc()):
            ?>
                <div class="activity-item">
                    <div class="activity-icon blue">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <div class="activity-info">
                        <h4><?php echo htmlspecialchars($row['activity_title']); ?></h4>
                        <p><?php echo htmlspecialchars($row['description']); ?></p>
                    </div>
                    <div class="activity-time"><?php echo htmlspecialchars($row['activity_time']); ?></div>
                </div>
            <?php
                endwhile;
            else:
                echo "<p>No recent activities found.</p>";
            endif;
            ?>
        </div>

        <div class="social-media">
            <a href="https://www.instagram.com" target="_blank">
                <i class="fab fa-instagram"></i> Instagram
            </a>
            <a href="https://www.linkedin.com/in/harshita-gautam/" target="_blank">
                <i class="fab fa-linkedin"></i> LinkedIn
            </a>
            <a href="mailto:harshita890gautam@gmail.com">
                <i class="fas fa-envelope"></i> Gmail
            </a>
        </div>
    </div>

    <div class="overlay" id="overlay"></div>
    <div class="partners-popup" id="partnersPopup">
        <span class="close-btn" id="closePopup">&times;</span>
        <h3>Your Learning Partners</h3>
        <div class="partner-item">
            <a href="https://www.geeksforgeeks.org/" target="_blank">
                <i class="fas fa-external-link-alt"></i> GeeksforGeeks
            </a>
        </div>
        <div class="partner-item">
            <a href="https://intellipaat.com/" target="_blank">
                <i class="fas fa-external-link-alt"></i> Intellipaat
            </a>
        </div>
        <div class="partner-item">
            <a href="https://www.simplilearn.com/" target="_blank">
                <i class="fas fa-external-link-alt"></i> Simplilearn
            </a>
        </div>
        <div class="partner-item">
            <a href="https://www.lpu.in/" target="_blank">
                <i class="fas fa-external-link-alt"></i> LPU
            </a>
        </div>
        <div class="partner-item">
            <a href="https://www.upes.ac.in/" target="_blank">
                <i class="fas fa-external-link-alt"></i> UPES
            </a>
        </div>
    </div>

    <script>
        document.getElementById('partners-stat').addEventListener('click', function() {
            document.getElementById('overlay').style.display = 'block';
            document.getElementById('partnersPopup').style.display = 'block';
        });

        document.getElementById('closePopup').addEventListener('click', function() {
            document.getElementById('overlay').style.display = 'none';
            document.getElementById('partnersPopup').style.display = 'none';
        });

        document.getElementById('overlay').addEventListener('click', function() {
            document.getElementById('overlay').style.display = 'none';
            document.getElementById('partnersPopup').style.display = 'none';
        });
    </script>
</body>
</html>