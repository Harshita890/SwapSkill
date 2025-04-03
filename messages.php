<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat Box</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Arial', sans-serif;
        }
        body {
            background: #f5f5f5;
            padding: 20px;
        }
        .chat-container {
            max-width: 600px;
            margin: 0 auto;
            background: white;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }
        .chat-header {
            padding: 15px;
            background: #432937;
            color: white;
            text-align: center;
        }
        .messages {
            height: 400px;
            padding: 15px;
            overflow-y: auto;
        }
        .message {
            margin-bottom: 15px;
            max-width: 80%;
        }
        .message.received {
            align-self: flex-start;
        }
        .message.sent {
            margin-left: auto;
            text-align: right;
        }
        .message-content {
            padding: 10px 15px;
            border-radius: 18px;
            display: inline-block;
        }
        .message.received .message-content {
            background: #f0f0f0;
        }
        .message.sent .message-content {
            background: #432937;
            color: white;
        }
        .message-input {
            padding: 15px;
            border-top: 1px solid #eee;
            display: flex;
        }
        .message-input input {
            flex: 1;
            padding: 10px 15px;
            border: 1px solid #ddd;
            border-radius: 20px;
            outline: none;
        }
        .message-input button {
            margin-left: 10px;
            padding: 10px 20px;
            background: #432937;
            color: white;
            border: none;
            border-radius: 20px;
            cursor: pointer;
        }
        /* Back to Dashboard box */
        .dashboard-box {
            margin-top: 15px;
            text-align: center;
        }
        .dashboard-box a {
            display: inline-block;
            padding: 10px 15px;
            background: #432937;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            transition: 0.3s;
        }
        .dashboard-box a:hover {
            background: #5a3e50;
        }
    </style>
</head>
<body>
    <div class="chat-container">
        <div class="chat-header">
            <h3>Harshita</h3>
        </div>
        <div class="messages" id="messages">
            <div class="message received">
                <div class="message-content">
                    Hey, can you help me with DSA?
                </div>
            </div>
            <div class="message sent">
                <div class="message-content">
                    Sure! What do you need help with?
                </div>
            </div>
            <div class="message received">
                <div class="message-content">
                    
                </div>
            </div>
        </div>
        <div class="message-input">
            <input type="text" id="messageInput" placeholder="Type a message...">
            <button onclick="sendMessage()">Send</button>
        </div>
    </div>

    <div class="dashboard-box">
        <a href="dashboard.php">← Back to Dashboard</a>
    </div>

    <script>
        function sendMessage() {
            const input = document.getElementById('messageInput');
            const message = input.value.trim();
            
            if (message) {
                const messagesDiv = document.getElementById('messages');
                
                // Create new message element
                const newMessage = document.createElement('div');
                newMessage.className = 'message sent';
                newMessage.innerHTML = `
                    <div class="message-content">
                        ${message}
                    </div>
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
    </script>
</body>
</html>
