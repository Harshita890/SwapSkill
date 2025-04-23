<?php
session_start();
require("include/db.php");

// Redirect to login if not authenticated
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Initialize variables
$error = '';
$success = '';
$formData = [
    'skill_name' => '',
    'description' => '',
    'video_link' => ''
];

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_skill'])) {
    // Sanitize and validate inputs
    $formData['skill_name'] = trim($_POST['skill_name'] ?? '');
    $formData['description'] = trim($_POST['description'] ?? '');
    $formData['video_link'] = trim($_POST['video_link'] ?? '');

    // Validation
    if (empty($formData['skill_name'])) {
        $error = "Skill name is required.";
    } elseif (strlen($formData['skill_name']) > 100) {
        $error = "Skill name must be less than 100 characters.";
    } elseif (empty($formData['description'])) {
        $error = "Description is required.";
    } else {
        // Insert into database using prepared statement
        $stmt = $conn->prepare("INSERT INTO skills (skill_name, description, video_link) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", 
            $formData['skill_name'], 
            $formData['description'], 
            $formData['video_link']
        );

        if ($stmt->execute()) {
            $success = "Skill added successfully!";
            // Clear form on success
            $formData = [
                'skill_name' => '',
                'description' => '',
                'video_link' => ''
            ];
        } else {
            $error = "Error adding skill: " . $conn->error;
        }
        $stmt->close();
    }
}

// Close database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Skill</title>
    <link rel="stylesheet" type="text/css" href="css.css">
    <style>
        .error { color: red; margin-bottom: 15px; }
        .success { color: green; margin-bottom: 15px; }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; }
        input[type="text"], textarea {
            width: 100%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        textarea { min-height: 100px; }
        button {
            background-color: #4CAF50;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        button:hover { background-color: #45a049; }
    </style>
</head>
<body>

<div class="main-content">
    <div class="top-bar">
        <div class="welcome-text">Add New Skill</div>
        <a href="dashboard.php" class="schedule-btn">← Back to Dashboard</a>
    </div>

    <div class="profile-container">
        <?php if ($error): ?>
            <div class="error"><?php echo htmlspecialchars($error); ?></div>
        <?php elseif ($success): ?>
            <div class="success"><?php echo htmlspecialchars($success); ?></div>
        <?php endif; ?>

        <form method="POST" action="add_skill.php">
            <div class="form-group">
                <label for="skill_name">Skill Name:*</label>
                <input type="text" id="skill_name" name="skill_name" 
                       value="<?php echo htmlspecialchars($formData['skill_name']); ?>" 
                       required maxlength="100">
            </div>

            <div class="form-group">
                <label for="description">Description:*</label>
                <textarea id="description" name="description" required><?php 
                    echo htmlspecialchars($formData['description']); 
                ?></textarea>
            </div>

            <div class="form-group">
                <label for="video_link">Video Link:</label>
                <input type="text" id="video_link" name="video_link" 
                       value="<?php echo htmlspecialchars($formData['video_link']); ?>">
                <small>Optional: Paste a YouTube or other video URL</small>
            </div>

            <button type="submit" name="add_skill">Add Skill</button>
        </form>
        
        <div class="dashboard-box" style="margin-top: 20px;">
            <a href="skills.php">← Back to Skills List</a>
        </div>
    </div>
</div>

</body>
</html>