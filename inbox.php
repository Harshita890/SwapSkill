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
    </style>
</head>
<body>

<h2>Your Inbox 📥</h2>

<?php if ($result->num_rows > 0): ?>
    <?php while ($row = $result->fetch_assoc()): ?>
        <div class="message-box">
            <h4>From: <?php echo htmlspecialchars($row['sender_name']); ?></h4>
            <p><?php echo nl2br(htmlspecialchars($row['message'])); ?></p>
            <time>🕒 <?php echo date('d M Y, h:i A', strtotime($row['timestamp'])); ?></time>
        </div>
    <?php endwhile; ?>
<?php else: ?>
    <p>No messages received yet.</p>
<?php endif; ?>

</body>
</html>
