<?php
session_start();
require_once('include/db.php');

if (!isset($_SESSION['user_id'])) {
    http_response_code(401);
    exit();
}

$user_id = $_SESSION['user_id'];
$stmt = $conn->prepare("
    SELECT m.*, u.username as sender_name 
    FROM messages m
    JOIN users u ON m.sender_id = u.id
    WHERE m.sender_id = ? OR m.receiver_id = ?
    ORDER BY m.timestamp DESC
    LIMIT 50
");
$stmt->bind_param("ii", $user_id, $user_id);
$stmt->execute();
$result = $stmt->get_result();
$messages = $result->fetch_all(MYSQLI_ASSOC);
$stmt->close();

$messages = array_reverse($messages);

foreach ($messages as $msg) {
    $class = $msg['sender_id'] == $user_id ? 'sent' : 'received';
    echo '<div class="message '.$class.'">';
    if ($msg['sender_id'] != $user_id) {
        echo '<div class="sender-name">'.htmlspecialchars($msg['sender_name']).'</div>';
    }
    echo '<div class="message-content">'.htmlspecialchars($msg['message_content']).'</div>';
    echo '<div class="message-time">'.date('h:i A', strtotime($msg['timestamp'])).'</div>';
    echo '</div>';
}
?>