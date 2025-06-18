<?php
session_start();
require_once('include/db.php');

if (!isset($_SESSION['user_id']) || $_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(400);
    exit();
}

$user_id = $_SESSION['user_id'];
$message = trim($_POST['message']);
$receiver_id = 2;

if (!empty($message)) {
    $stmt = $conn->prepare("
        INSERT INTO messages 
        (sender_id, receiver_id, message_content) 
        VALUES (?, ?, ?)
    ");
    $stmt->bind_param("iis", $user_id, $receiver_id, $message);
    $stmt->execute();
    $stmt->close();
}
?>