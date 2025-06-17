<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

include('include/db.php');

// Fetch logged-in user's info
$user_id = $_SESSION['user_id'];
$user_result = mysqli_query($conn, "SELECT username FROM users WHERE id = $user_id");
$user_row = mysqli_fetch_assoc($user_result);
$username = $user_row['username'];

// Fetch chat messages (latest 50)
$messages_result = mysqli_query($conn, "SELECT * FROM messages ORDER BY timestamp ASC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>SkillSwap - Chat</title>
    <link rel="stylesheet" href="css.css">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600;700&display=swap" rel="stylesheet">
</head>
<body>
    <div class="sidebar">
        <h2>SkillSwap</h2>
        <ul>
            <li><a href="dashboard.php">Dashboard</a></li>
            <li><a href="profile.php">Profile</a></li>
            <li><a href="skills.php">Skills</a></li>
            <li class="active"><a href="messages.php">Messages</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </div>

    <div class="main-content">
        <div class="chat-container">
            <div class="chat-header">
                <div class="user-avatar"><?php echo strtoupper(substr($username, 0, 1)); ?></div>
                <h3><?php echo htmlspecialchars($username); ?></h3>
            </div>
            <div class="messages" id="messages">
                <?php while($msg = mysqli_fetch_assoc($messages_result)): ?>
                    <div class="message <?php echo $msg['sender_id'] == $user_id ? 'sent' : 'received'; ?>">
                        <div class="message-content"><?php echo htmlspecialchars($msg['message']); ?></div>
                        <div class="message-time"><?php echo date('h:i A', strtotime($msg['timestamp'])); ?></div>
                    </div>
                <?php endwhile; ?>
            </div>
            <div class="message-input">
                <input type="text" id="messageInput" placeholder="Type a message...">
                <button onclick="sendMessage()">Send <i class="fas fa-paper-plane"></i></button>
            </div>
        </div>
    </div>

    <script>
        function sendMessage() {
            const input = document.getElementById('messageInput');
            const message = input.value.trim();

            if (message) {
                fetch('send_message.php', {
                    method: 'POST',
                    headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                    body: 'message=' + encodeURIComponent(message)
                })
                .then(response => response.text())
                .then(() => {
                    input.value = '';
                    loadMessages();
                });
            }
        }

        function loadMessages() {
            fetch('load_messages.php')
                .then(response => response.text())
                .then(data => {
                    document.getElementById('messages').innerHTML = data;
                    document.getElementById('messages').scrollTop = document.getElementById('messages').scrollHeight;
                });
        }

        setInterval(loadMessages, 3000); // Auto-refresh every 3 seconds

        document.getElementById('messageInput').addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                sendMessage();
            }
        });

        window.onload = loadMessages;
    </script>
</body>
</html>
