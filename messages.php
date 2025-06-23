<?php
session_start();
require("include/db.php");

// Redirect to login if not logged in
if (!isset($_SESSION['user_id']) || !isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$chatSelected = false;
$other_user = null;
$other_user_id = null;

// Get list of all other users
$users_list = mysqli_query($conn, "SELECT id, username FROM users WHERE id != " . $_SESSION['user_id']);

// Check if a chat is selected
if (isset($_GET['other_user_id'])) {
    $other_user_id = intval($_GET['other_user_id']);
    $stmt = $conn->prepare("SELECT username FROM users WHERE id = ?");
    $stmt->bind_param("i", $other_user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $other_user = $result->fetch_assoc();
    $stmt->close();

    if ($other_user) {
        $chatSelected = true;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>SkillSwap Chat</title>
    <style>
    :root {
        --black: #111;
        --yellow: #ffd700;
        --green: #32cd32;
        --gray: #f0f0f0;
    }

    body {
        font-family: 'Nunito', sans-serif;
        background: var(--black);
        color: white;
        margin: 0;
        padding: 30px;
    }

    h2 {
        color: var(--yellow);
        margin-bottom: 20px;
    }

    form, select {
        margin-bottom: 20px;
    }

    #chat-container {
        background: #1e1e1e;
        border-radius: 16px;
        padding: 30px;
        max-width: 1000px;
        height: 80vh;
        margin: auto;
        box-shadow: 0 0 25px rgba(255, 255, 255, 0.05);
        display: flex;
        flex-direction: column;
    }

    #chat-header {
        font-weight: 700;
        font-size: 24px;
        color: var(--yellow);
        margin-bottom: 20px;
        border-bottom: 2px solid var(--yellow);
        padding-bottom: 10px;
    }

    #messages {
        flex: 1;
        overflow-y: auto;
        background: var(--black);
        border: 2px solid var(--yellow);
        padding: 20px;
        border-radius: 12px;
        margin-bottom: 20px;
    }

    .message {
        margin-bottom: 12px;
        padding: 14px 20px;
        border-radius: 20px;
        max-width: 70%;
        font-size: 16px;
    }

    .sent-message {
        background: var(--green);
        color: black;
        align-self: flex-end;
    }

    .received-message {
        background: var(--yellow);
        color: black;
        align-self: flex-start;
    }

    #message-form {
        display: flex;
        gap: 12px;
        margin-top: auto;
    }

    #message-input {
        flex: 1;
        padding: 14px 20px;
        border: 2px solid var(--green);
        border-radius: 30px;
        font-size: 16px;
        outline: none;
        background: #2b2b2b;
        color: white;
    }

    #message-input::placeholder {
        color: #aaa;
    }

    button {
        padding: 14px 24px;
        background: var(--yellow);
        color: black;
        border: none;
        font-weight: bold;
        border-radius: 30px;
        cursor: pointer;
        transition: 0.3s;
    }

    button:hover {
        background: var(--green);
        color: black;
    }

    select {
        padding: 10px 16px;
        border-radius: 8px;
        border: 1px solid var(--yellow);
        background: #2b2b2b;
        color: white;
    }

    option {
        color: black;
    }

    @media (max-width: 768px) {
        #chat-container {
            padding: 20px;
            max-height: 90vh;
        }

        .message {
            max-width: 85%;
        }
    }
</style>

</head>
<body>

<h2>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h2>

<?php if (!$chatSelected): ?>
    <form method="GET" action="messages.php">
        <label>Select someone to chat with:</label>
        <select name="other_user_id" required>
            <option value="">-- Choose a user --</option>
            <?php while ($row = mysqli_fetch_assoc($users_list)): ?>
                <option value="<?php echo $row['id']; ?>">
                    <?php echo htmlspecialchars($row['username']); ?>
                </option>
            <?php endwhile; ?>
        </select>
        <button type="submit">Start Chat</button>
    </form>

<?php else: ?>
    <div id="chat-container">
        <div id="chat-header">
            Chat with <?php echo htmlspecialchars($other_user['username']); ?>
        </div>

        <div id="messages"></div>

        <form id="message-form">
            <input type="text" id="message-input" placeholder="Type your message..." required />
            <button type="submit">Send</button>
        </form>
    </div>

    <script>
        function loadMessages() {
            fetch('get_messages.php?other_user_id=<?php echo $other_user_id; ?>')
                .then(res => res.json())
                .then(data => {
                    const container = document.getElementById('messages');
                    container.innerHTML = '';
                    data.forEach(msg => {
                        const div = document.createElement('div');
                        div.className = 'message ' + (msg.sender_id == <?php echo $_SESSION['user_id']; ?> ? 'sent-message' : 'received-message');
                        div.textContent = msg.message;
                        container.appendChild(div);
                    });
                    container.scrollTop = container.scrollHeight;
                });
        }

        document.getElementById('message-form').addEventListener('submit', function(e) {
            e.preventDefault();
            const input = document.getElementById('message-input');
            const message = input.value.trim();
            if (message) {
                fetch('send_message.php', {
                    method: 'POST',
                    headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                    body: `receiver_id=<?php echo $other_user_id; ?>&message=${encodeURIComponent(message)}`
                })
                .then(res => res.json())
                .then(data => {
                    if (data.status === 'success') {
                        input.value = '';
                        loadMessages();
                    }
                });
            }
        });

        loadMessages();
        setInterval(loadMessages, 3000);
    </script>
<?php endif; ?>

</body>
</html>
