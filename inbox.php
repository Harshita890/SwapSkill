<?php
session_start();
require("include/db.php");

if (!isset($_SESSION['user_id'])) {
    header("location: login.php");
    exit();
}

$current_user_id = $_SESSION['user_id'];

// Fetch latest messages received by the current user
$query = "
    SELECT cm.*, u.username AS sender_name
    FROM chat_messages cm
    JOIN users u ON cm.sender_id = u.id
    WHERE cm.receiver_id = ?
    ORDER BY cm.timestamp DESC
";

$stmt = $conn->prepare($query);
$stmt->bind_param("i", $current_user_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Inbox - Received Messages</title>
    <style>
        body {
            font-family: 'Nunito', sans-serif;
            background-color: #1a1a1a;
            color: #fff;
            padding: 20px;
        }
        .message-box {
            background-color: #222;
            border: 1px solid #ffd100;
            border-left: 8px solid #32cd32;
            padding: 15px;
            margin-bottom: 15px;
            border-radius: 10px;
            transition: background 0.2s;
        }
        .message-box:hover {
            background-color: #2a2a2a;
        }
        .message-box h4 {
            margin: 0;
            color: #ffd100;
        }
        .message-box p {
            margin: 8px 0;
        }
        .message-box time {
            font-size: 0.9em;
            color: #aaa;
        }
        .dashboard-link {
            display: inline-block;
            margin-bottom: 20px;
            background-color: #ffd100;
            color: #000;
            padding: 10px 15px;
            border-radius: 5px;
            font-weight: bold;
            text-decoration: none;
        }
        .dashboard-link:hover {
            background-color: #ffcc00;
        }
        a {
            text-decoration: none;
            color: inherit;
        }
    </style>
</head>
<body>

<a class="dashboard-link" href="dashboard.php">&larr; Back to Dashboard</a>
<h2>Your Inbox 📥</h2>

<?php if ($result->num_rows > 0): ?>
    <?php while ($row = $result->fetch_assoc()): ?>
        <a href="messages.php?user_id=<?php echo $row['sender_id']; ?>">
            <div class="message-box">
                <h4>From: <?php echo htmlspecialchars($row['sender_name']); ?></h4>
                <p><?php echo nl2br(htmlspecialchars($row['message'])); ?></p>
                <time>🕒 <?php echo date('d M Y, h:i A', strtotime($row['timestamp'])); ?></time>
            </div>
        </a>
    <?php endwhile; ?>
<?php else: ?>
    <p>No messages received yet.</p>
<?php endif; ?>

</body>
</html>
