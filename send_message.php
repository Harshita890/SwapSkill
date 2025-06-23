<?php
session_start();
require("include/db.php");

if (!isset($_SESSION['user_id']) || $_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(400);
    echo json_encode(['status' => 'error', 'message' => 'Invalid request']);
    exit();
}

$sender_id = $_SESSION['user_id'];
$receiver_id = intval($_POST['receiver_id']);
$message = trim($_POST['message']);

if ($message !== '') {
    $stmt = $conn->prepare("INSERT INTO chat_messages (sender_id, receiver_id, message, timestamp, is_read) VALUES (?, ?, ?, NOW(), 0)");
    $stmt->bind_param("iis", $sender_id, $receiver_id, $message);
    $stmt->execute();
    echo json_encode(['status' => 'success']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Empty message']);
}
?>
