<?php
session_start();
require("include/db.php");

if(!isset($_SESSION['username'])){
    header("location: login.php");
}

if(isset($_GET['id'])){
    $id = $_GET['id'];
    $query = "SELECT * FROM skills WHERE id = $id";
    $result = mysqli_query($conn, $query);
    $skill = mysqli_fetch_assoc($result);
}

if(isset($_POST['update'])){
    $skill_name = $_POST['skill_name'];
    $description = $_POST['description'];
    $video_link = $_POST['video_link'];

    $update_query = "UPDATE skills SET 
                        skill_name='$skill_name', 
                        description='$description', 
                        video_link='$video_link' 
                    WHERE id=$id";
    mysqli_query($conn, $update_query);
    header("location: skills.php");
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Skill</title>
    <link rel="stylesheet" type="text/css" href="css.css">
</head>
<body>

<div class="main-content">
    <div class="top-bar">
        <div class="welcome-text">Edit Skill</div>
        <a href="dashboard.php" class="schedule-btn">← Back to Dashboard</a>
    </div>

    <div class="profile-container">
        <form method="POST">
            <div class="form-group">
                <label>Skill Name:</label>
                <input type="text" name="skill_name" value="<?php echo $skill['skill_name']; ?>" required>
            </div>

            <div class="form-group">
                <label>Description:</label>
                <textarea name="description" required><?php echo $skill['description']; ?></textarea>
            </div>

            <div class="form-group">
                <label>Video Link:</label>
                <input type="text" name="video_link" value="<?php echo $skill['video_link']; ?>">
            </div>

            <button type="submit" name="update">Update Skill</button>
        </form>
        <div class="dashboard-box">
            <a href="skills.php">← Back to Skills List</a>
        </div>
    </div>
</div>

</body>
</html>