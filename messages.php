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
            margin: 20px;
            display: flex;
            flex-direction: column;
        }

        .chat-container {
            flex: 1;
            background: white;
            border-radius: 15px;
            box-shadow: 0 5px 25px rgba(0, 0, 0, 0.08);
            overflow: hidden;
            display: flex;
            flex-direction: column;
        }

        .chat-header {
            padding: 15px 20px;
            background: linear-gradient(135deg, var(--dark), var(--darker));
            color: var(--primary);
            display: flex;
            align-items: center;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .chat-header h3 {
            font-weight: 700;
            margin-left: 10px;
        }

        .chat-header .user-avatar {
            width: 40px;
            height: 40px;
            background: var(--primary);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            color: var(--dark);
            box-shadow: 0 3px 8px rgba(255, 215, 0, 0.4);
        }

        .messages {
            height: 450px;
            padding: 20px;
            overflow-y: auto;
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .message {
            max-width: 80%;
            display: flex;
            flex-direction: column;
        }

        .message.received {
            align-self: flex-start;
        }

        .message.sent {
            align-self: flex-end;
        }

        .message-content {
            padding: 12px 18px;
            border-radius: 18px;
            position: relative;
            font-size: 0.95rem;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
        }

        .message.received .message-content {
            background: #f0f0f0;
            border-bottom-left-radius: 5px;
        }

        .message.sent .message-content {
            background: linear-gradient(135deg, var(--secondary), var(--secondary-dark));
            color: white;
            border-bottom-right-radius: 5px;
        }

        .message-time {
            font-size: 0.7rem;
            margin-top: 5px;
            opacity: 0.7;
            align-self: flex-end;
        }

        .message.received .message-time {
            align-self: flex-start;
        }

        .message-input {
            padding: 15px 20px;
            border-top: 1px solid #eee;
            display: flex;
            align-items: center;
            background: white;
        }

        .message-input input {
            flex: 1;
            padding: 12px 20px;
            border: 2px solid #e0e0e0;
            border-radius: 25px;
            outline: none;
            font-size: 0.95rem;
            transition: all 0.3s;
        }

        .message-input input:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(255, 215, 0, 0.2);
        }

        .message-input button {
            margin-left: 10px;
            padding: 12px 25px;
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            color: var(--dark);
            border: none;
            border-radius: 25px;
            cursor: pointer;
            font-weight: 600;
            display: flex;
            align-items: center;
            transition: all 0.3s;
            box-shadow: 0 3px 8px rgba(0, 0, 0, 0.1);
        }

        .message-input button:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 12px rgba(0, 0, 0, 0.15);
        }

        .message-input button i {
            margin-left: 8px;
        }

        /* Responsive */
        @media (max-width: 1200px) {
            .sidebar { width: 220px; }
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
            .messages {
                height: 350px;
            }
        }

        @media (max-width: 480px) {
            .main-content { 
                margin: 10px; 
                padding: 15px;
            }
            .message-input button {
                padding: 12px 15px;
            }
            .message-input button span {
                display: none;
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
                <div class="message sent">
                    <div class="message-content">
                        Absolutely! I'm free tomorrow after 4 PM. Would that work for you?
                    </div>
                    <div class="message-time">10:35 AM</div>
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
                
                // Create new message element
                const newMessage = document.createElement('div');
                newMessage.className = 'message sent';
                newMessage.innerHTML = `
                    <div class="message-content">
                        ${message}
                    </div>
                    <div class="message-time">${timeString}</div>
                `;
                
                // Add to messages
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

        // Scroll to bottom on load
        window.onload = function() {
            document.getElementById('messages').scrollTop = document.getElementById('messages').scrollHeight;
        };
    </script>
</body>
</html>