<?php
session_start();
require_once('include/db.php');

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$stmt = $conn->prepare("SELECT username FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$user_result = $stmt->get_result();
$user_row = $user_result->fetch_assoc();
$username = $user_row['username'];
$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>SkillSwap - Chat</title>
    <link rel="stylesheet" href="css.css">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
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
            <div class="messages" id="messages"></div>
            <div class="message-input">
                <input type="text" id="messageInput" placeholder="Type a message..." autocomplete="off">
                <button onclick="sendMessage()">Send <i class="fas fa-paper-plane"></i></button>
            </div>
        </div>
    </div>

    <script>
        function scrollToBottom() {
            const messagesDiv = document.getElementById('messages');
            messagesDiv.scrollTop = messagesDiv.scrollHeight;
        }

        function sendMessage() {
            const input = document.getElementById('messageInput');
            const message = input.value.trim();

            if (message) {
                fetch('send_message.php', {
                    method: 'POST',
                    headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                    body: 'message=' + encodeURIComponent(message)
                })
                .then(response => {
                    if (response.ok) {
                        input.value = '';
                        loadMessages();
                    }
                })
                .catch(error => console.error('Error:', error));
            }
        }

        function loadMessages() {
            fetch('get_messages.php')
                .then(response => response.text())
                .then(data => {
                    document.getElementById('messages').innerHTML = data;
                    scrollToBottom();
                })
                .catch(error => console.error('Error:', error));
        }

        document.getElementById('messageInput').addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                sendMessage();
            }
        });

        loadMessages();
        setInterval(loadMessages, 2000);
    </script>
</body>
</html>