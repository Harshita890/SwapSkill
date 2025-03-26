<?php
session_start();
include 'includes/db.php';

$user_id = $_SESSION['user_id'];

$query = $conn->query("SELECT name FROM users WHERE id = $user_id");
$user = $query->fetch();

$skills = $conn->query("SELECT skill_name FROM skills WHERE user_id = $user_id")->fetchAll();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $skill_name = $_POST['skill_name'];
    $conn->query("INSERT INTO skills (user_id, skill_name) VALUES ($user_id, '$skill_name')");
    header("Location: profile.php");
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Profile</title>
    <link rel="stylesheet" href="new.css">
</head>
<body>
    <div class="profile-container">
        <h2>Welcome, <?php echo $user['name']; ?></h2>

        <h3>Your Skills</h3>
        <ul class="skills-list">
            <?php foreach ($skills as $skill) { echo "<li>{$skill['skill_name']}</li>"; } ?>
        </ul>

        <form method="post">
            <input type="text" name="skill_name" placeholder="Enter skill" required>
            <button type="submit">Add Skill</button>
        </form>
    </div>
</body>
</html>
