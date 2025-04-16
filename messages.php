<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SkillSwap - Chat</title>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="css.css">
</head>
<body>
    <div class="sidebar">
        <h2>SkillSwap</h2>
        <ul>
            <li><a href="dashboard.php"><i class="fas fa-chart-line"></i> Dashboard</a></li>
            <li><a href="profile.php"><i class="fas fa-user"></i> Profile</a></li>
            <li><a href="skills.php"><i class="fas fa-graduation-cap"></i> Skills</a></li>
            <li class="active"><a href="messages.php"><i class="fas fa-comment-alt"></i> Messages</a></li>
            <li><a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
        </ul>
    </div>

    <div class="main-content">
        <div class="chat-container">
            <div class="chat-header">
                <div class="user-avatar">H</div>
                <h3>Harshita</h3>
            </div>
            <div class="messages" id="messages">
                <div class="message received">
                    <div class="message-content">
                        Hey, can you help me with DSA?
                    </div>
                    <div class="message-time">10:30 AM</div>
                </div>
                <div class="message sent">
                    <div class="message-content">
                        Sure! What do you need help with?
                    </div>
                    <div class="message-time">10:32 AM</div>
                </div>
                <div class="message received">
                    <div class="message-content">
                        I'm struggling with linked list implementations. Can we schedule a session?
                    </div>
                    <div class="message-time">10:33 AM</div>
                </div>
            </div>
            <div class="message-input">
                <input type="text" id="messageInput" placeholder="Type a message...">
                <button onclick="sendMessage()"><span>Send</span> <i class="fas fa-paper-plane"></i></button>
            </div>
        </div>
    </div>

    <script>
        function sendMessage() {
            const input = document.getElementById('messageInput');
            const message = input.value.trim();
            
            if (message) {
                const messagesDiv = document.getElementById('messages');
                const now = new Date();
                const hours = now.getHours();
                const minutes = now.getMinutes();
                const timeString = `${hours}:${minutes < 10 ? '0' + minutes : minutes} ${hours >= 12 ? 'PM' : 'AM'}`;
                
                const newMessage = document.createElement('div');
                newMessage.className = 'message sent';
                newMessage.innerHTML = `
                    <div class="message-content">
                        ${message}
                    </div>
                    <div class="message-time">${timeString}</div>
                `;
                
                
                messagesDiv.appendChild(newMessage);
                
                input.value = '';
                
                messagesDiv.scrollTop = messagesDiv.scrollHeight;
            }
        }
        
        document.getElementById('messageInput').addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                sendMessage();
            }
        });

        
        window.onload = function() {
            document.getElementById('messages').scrollTop = document.getElementById('messages').scrollHeight;
        };
    </script>
</body>
</html>