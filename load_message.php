<?php
session_start();
if (!isset($_SESSION['user_id'])) exit();

include('include/db.php');
$user_id = $_SESSION['user_id'];

$messages_result = mysqli_query($conn, "
    SELECT m.*, u.username 
    FROM messages m 
    JOIN users u ON m.sender_id = u.id 
    ORDER BY m.timestamp ASC
");

while ($msg = mysqli_fetch_assoc($messages_result)) {
    $isMe = $msg['sender_id'] == $user_id ? 'sent' : 'received';
    echo '<div class="message ' . $isMe . '">';
    echo '<div class="message-content">' . htmlspecialchars($msg['message']) . '</div>';
    echo '<div class="message-time">' . date('h:i A', strtotime($msg['timestamp'])) . '</div>';
    echo '</div>';
}
?>
