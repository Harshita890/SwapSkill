<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_skill'])) {
    // Here you would typically process the form and add to database
    // For now, we'll just simulate it
    $skill_name = htmlspecialchars($_POST['skill_name']);
    $skill_description = htmlspecialchars($_POST['skill_description']);
    $skill_level = intval($_POST['skill_level']);
    
    // In a real application, you would:
    // 1. Validate inputs
    // 2. Insert into database
    // 3. Redirect or show success message
    
    // For this example, we'll just show an alert
    echo "<script>alert('Skill added successfully!');</script>";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SkillSwap - Skills</title>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: 'Nunito', sans-serif;
    }

    :root {
        --primary: #FFD700;       /* Gold/Yellow */
        --primary-dark: #FFC000;   /* Darker Gold */
        --secondary: #2E8B57;      /* Sea Green */
        --secondary-dark: #1E6F4E; /* Darker Green */
        --dark: #121212;          /* Deep Black */
        --darker: #0A0A0A;       /* Even Darker */
        --light: #F8F8F8;         /* Light background */
        --lighter: #FFFFFF;       /* White */
        --accent: #3A3A3A;        /* Dark Gray */
        --text-dark: #121212;
        --text-light: #FFFFFF;
    }

    body {
        display: flex;
        background: var(--light);
        min-height: 100vh;
        color: var(--text-dark);
    }

    .sidebar {
        width: 250px;
        background: var(--dark);
        padding: 20px;
        height: 100vh;
        border-right: 3px solid var(--primary);
    }

    .sidebar h2 {
        color: var(--primary);
        text-align: center;
        margin-bottom: 30px;
        font-weight: 700;
        font-size: 1.8rem;
        letter-spacing: 1px;
    }

    .sidebar ul {
        list-style: none;
    }

    .sidebar ul li {
        padding: 12px 15px;
        margin-bottom: 10px;
        border-radius: 8px;
        cursor: pointer;
        color: var(--text-light);
        transition: all 0.3s ease;
    }

    .sidebar ul li:hover {
        background: var(--primary);
        color: var(--dark);
        transform: translateX(5px);
    }

    .sidebar ul li.active {
        background: var(--primary);
        color: var(--dark);
        font-weight: 600;
        box-shadow: 0 4px 8px rgba(255, 215, 0, 0.3);
    }

    .sidebar ul li a {
        text-decoration: none;
        color: inherit;
        display: flex;
        align-items: center;
    }

    .sidebar ul li i {
        margin-right: 10px;
        width: 20px;
        text-align: center;
    }

    .main-content {
        flex: 1;
        padding: 30px;
        background: var(--light);
        margin: 20px;
        border-radius: 15px;
        box-shadow: 0 5px 25px rgba(0, 0, 0, 0.08);
        overflow-y: auto;
    }

    .top-bar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 30px;
    }

    .search-container {
        position: relative;
        width: 350px;
    }

    .search-container input {
        padding: 12px 15px 12px 45px;
        width: 100%;
        border: 2px solid #ddd;
        border-radius: 30px;
        background: white;
        font-size: 0.9rem;
        transition: all 0.3s;
    }

    .search-container input:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(255, 215, 0, 0.2);
        outline: none;
    }

    .search-container i {
        position: absolute;
        left: 20px;
        top: 50%;
        transform: translateY(-50%);
        color: var(--accent);
    }

    .welcome-text {
        font-weight: 600;
        color: var(--dark);
        background: linear-gradient(135deg, var(--primary), var(--primary-dark));
        padding: 12px 25px;
        border-radius: 30px;
        box-shadow: 0 4px 12px rgba(255, 215, 0, 0.3);
        font-size: 1rem;
    }

    .welcome-text span {
        color: var(--dark);
        font-weight: 700;
    }

    /* Skills Section Styles */
    .skills-section {
        background: white;
        padding: 30px;
        border-radius: 12px;
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.05);
        margin-bottom: 30px;
        border-left: 5px solid var(--primary);
        transition: transform 0.3s;
    }

    .skills-section:hover {
        transform: translateY(-3px);
    }

    .skills-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 25px;
    }

    .skills-header h2 {
        font-size: 24px;
        font-weight: 700;
        color: var(--dark);
        position: relative;
        padding-bottom: 10px;
    }

    .skills-header h2::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 50px;
        height: 3px;
        background: var(--primary);
    }

    .btn {
        padding: 12px 25px;
        border-radius: 30px;
        text-decoration: none;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        cursor: pointer;
        transition: all 0.3s;
        font-size: 0.95rem;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        border: none;
    }

    .btn:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 15px rgba(0, 0, 0, 0.2);
    }

    .btn i {
        margin-right: 10px;
    }

    .primary-btn {
        background: linear-gradient(135deg, var(--secondary), var(--secondary-dark));
        color: white;
    }

    .primary-btn:hover {
        background: linear-gradient(135deg, var(--secondary-dark), var(--secondary));
    }

    .secondary-btn {
        background: linear-gradient(135deg, var(--primary), var(--primary-dark));
        color: var(--dark);
    }

    .secondary-btn:hover {
        background: linear-gradient(135deg, var(--primary-dark), var(--primary));
    }

    .skills-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 25px;
    }

    .skill-card {
        background: white;
        border-radius: 12px;
        padding: 20px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        border: 1px solid rgba(0, 0, 0, 0.05);
        transition: all 0.3s;
    }

    .skill-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        border-color: var(--primary);
    }

    .skill-card h3 {
        font-size: 1.2rem;
        margin-bottom: 10px;
        color: var(--dark);
    }

    .skill-card p {
        color: #666;
        margin-bottom: 15px;
        font-size: 0.9rem;
    }

    .skill-level {
        height: 8px;
        background: #eee;
        border-radius: 10px;
        margin-bottom: 15px;
        overflow: hidden;
    }

    .skill-level-fill {
        height: 100%;
        background: linear-gradient(135deg, var(--secondary), var(--secondary-dark));
        border-radius: 10px;
    }

    .skill-actions {
        display: flex;
        justify-content: space-between;
        margin-top: 20px;
    }

    .skill-actions .btn {
        padding: 8px 15px;
        font-size: 0.85rem;
    }

    /* Modal Styles */
    .modal {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        z-index: 1000;
        justify-content: center;
        align-items: center;
    }

    .modal-content {
        background-color: white;
        padding: 30px;
        border-radius: 12px;
        width: 90%;
        max-width: 500px;
        box-shadow: 0 5px 30px rgba(0, 0, 0, 0.3);
        transform: translateY(-50px);
        opacity: 0;
        transition: all 0.3s ease;
    }

    .modal.active {
        display: flex;
    }

    .modal.active .modal-content {
        transform: translateY(0);
        opacity: 1;
    }

    .modal-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
    }

    .modal-header h3 {
        font-size: 1.5rem;
        color: var(--dark);
    }

    .close-btn {
        background: none;
        border: none;
        font-size: 1.5rem;
        cursor: pointer;
        color: var(--accent);
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-group label {
        display: block;
        margin-bottom: 8px;
        font-weight: 600;
        color: var(--dark);
    }

    .form-group input,
    .form-group textarea,
    .form-group select {
        width: 100%;
        padding: 12px 15px;
        border: 2px solid #ddd;
        border-radius: 8px;
        font-size: 1rem;
        transition: all 0.3s;
    }

    .form-group input:focus,
    .form-group textarea:focus,
    .form-group select:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(255, 215, 0, 0.2);
        outline: none;
    }

    .form-group textarea {
        min-height: 100px;
        resize: vertical;
    }

    .form-actions {
        display: flex;
        justify-content: flex-end;
        gap: 15px;
    }

    /* Responsive */
    @media (max-width: 1200px) {
        .sidebar { width: 220px; }
        .main-content { padding: 25px; }
    }

    @media (max-width: 992px) {
        .skills-grid {
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
        }
    }

    @media (max-width: 768px) {
        body { flex-direction: column; }
        .sidebar {
            width: 100%;
            height: auto;
            padding: 15px;
            border-right: none;
            border-bottom: 3px solid var(--primary);
        }
        .sidebar ul {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 10px;
        }
        .sidebar ul li {
            margin-bottom: 0;
        }
        .main-content { 
            margin: 15px; 
            padding: 20px;
        }
        .top-bar {
            flex-direction: column;
            gap: 15px;
        }
        .search-container {
            width: 100%;
        }
        .welcome-text {
            width: 100%;
            text-align: center;
        }
    }

    @media (max-width: 480px) {
        .main-content { 
            margin: 10px; 
            padding: 15px;
        }
        .skills-section {
            padding: 20px;
        }
        .skills-grid {
            grid-template-columns: 1fr;
        }
        .modal-content {
            padding: 20px;
            width: 95%;
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
                <input type="text" placeholder="Search skills, users, resources...">
            </div>
            <div class="welcome-text">
                Welcome back, <span><?php echo htmlspecialchars($_SESSION['username']); ?></span>
            </div>
        </div>
        
        <div class="skills-section">
            <div class="skills-header">
                <h2>My Skills</h2>
                <button class="btn primary-btn" id="addSkillBtn">
                    <i class="fas fa-plus"></i> Add Skill
                </button>
            </div>
            <div class="skills-grid">
                <div class="skill-card">
                    <h3>Web Development</h3>
                    <p>HTML, CSS, JavaScript, PHP</p>
                    <div class="skill-level">
                        <div class="skill-level-fill" style="width: 85%"></div>
                    </div>
                    <div class="skill-actions">
                        <button class="btn secondary-btn">
                            <i class="fas fa-edit"></i> Edit
                        </button>
                        <button class="btn primary-btn">
                            <i class="fas fa-share-alt"></i> Share
                        </button>
                    </div>
                </div>
                <div class="skill-card">
                    <h3>Graphic Design</h3>
                    <p>Photoshop, Illustrator</p>
                    <div class="skill-level">
                        <div class="skill-level-fill" style="width: 70%"></div>
                    </div>
                    <div class="skill-actions">
                        <button class="btn secondary-btn">
                            <i class="fas fa-edit"></i> Edit
                        </button>
                        <button class="btn primary-btn">
                            <i class="fas fa-share-alt"></i> Share
                        </button>
                    </div>
                </div>
                <div class="skill-card">
                    <h3>Video Editing</h3>
                    <p>Premiere Pro, After Effects</p>
                    <div class="skill-level">
                        <div class="skill-level-fill" style="width: 60%"></div>
                    </div>
                    <div class="skill-actions">
                        <button class="btn secondary-btn">
                            <i class="fas fa-edit"></i> Edit
                        </button>
                        <button class="btn primary-btn">
                            <i class="fas fa-share-alt"></i> Share
                        </button>
                    </div>
                </div>
                <div class="skill-card">
                    <h3>UI/UX Design</h3>
                    <p>Figma, Adobe XD, User Research</p>
                    <div class="skill-level">
                        <div class="skill-level-fill" style="width: 75%"></div>
                    </div>
                    <div class="skill-actions">
                        <button class="btn secondary-btn">
                            <i class="fas fa-edit"></i> Edit
                        </button>
                        <button class="btn primary-btn">
                            <i class="fas fa-share-alt"></i> Share
                        </button>
                    </div>
                </div>
                <div class="skill-card">
                    <h3>Python Programming</h3>
                    <p>Django, Flask, Data Analysis</p>
                    <div class="skill-level">
                        <div class="skill-level-fill" style="width: 65%"></div>
                    </div>
                    <div class="skill-actions">
                        <button class="btn secondary-btn">
                            <i class="fas fa-edit"></i> Edit
                        </button>
                        <button class="btn primary-btn">
                            <i class="fas fa-share-alt"></i> Share
                        </button>
                    </div>
                </div>
                <div class="skill-card">
                    <h3>Digital Marketing</h3>
                    <p>SEO, Social Media, Analytics</p>
                    <div class="skill-level">
                        <div class="skill-level-fill" style="width: 80%"></div>
                    </div>
                    <div class="skill-actions">
                        <button class="btn secondary-btn">
                            <i class="fas fa-edit"></i> Edit
                        </button>
                        <button class="btn primary-btn">
                            <i class="fas fa-share-alt"></i> Share
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Skill Modal -->
    <div class="modal" id="addSkillModal">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Add New Skill</h3>
                <button class="close-btn" id="closeModalBtn">&times;</button>
            </div>
            <form method="POST" action="skills.php">
                <div class="form-group">
                    <label for="skill_name">Skill Name</label>
                    <input type="text" id="skill_name" name="skill_name" required placeholder="e.g., Web Development">
                </div>
                <div class="form-group">
                    <label for="skill_description">Description</label>
                    <textarea id="skill_description" name="skill_description" required placeholder="Describe your skill, technologies used, etc."></textarea>
                </div>
                <div class="form-group">
                    <label for="skill_level">Skill Level</label>
                    <select id="skill_level" name="skill_level" required>
                        <option value="">Select your skill level</option>
                        <option value="20">Beginner (1-20%)</option>
                        <option value="40">Intermediate (21-40%)</option>
                        <option value="60">Competent (41-60%)</option>
                        <option value="80">Proficient (61-80%)</option>
                        <option value="100">Expert (81-100%)</option>
                    </select>
                </div>
                <div class="form-actions">
                    <button type="button" class="btn secondary-btn" id="cancelBtn">Cancel</button>
                    <button type="submit" class="btn primary-btn" name="add_skill">Save Skill</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Modal functionality
        const addSkillBtn = document.getElementById('addSkillBtn');
        const closeModalBtn = document.getElementById('closeModalBtn');
        const cancelBtn = document.getElementById('cancelBtn');
        const modal = document.getElementById('addSkillModal');

        addSkillBtn.addEventListener('click', () => {
            modal.classList.add('active');
        });

        closeModalBtn.addEventListener('click', () => {
            modal.classList.remove('active');
        });

        cancelBtn.addEventListener('click', () => {
            modal.classList.remove('active');
        });

        // Close modal when clicking outside the modal content
        modal.addEventListener('click', (e) => {
            if (e.target === modal) {
                modal.classList.remove('active');
            }
        });

        // In a real application, you would handle form submission with AJAX
        // Here's a basic example of how you might do it:
        /*
        document.querySelector('form').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            
            fetch('add_skill.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Skill added successfully!');
                    modal.classList.remove('active');
                    // Refresh the skills list or add the new skill to the DOM
                } else {
                    alert('Error: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred. Please try again.');
            });
        });
        */
    </script>
</body>
</html>