<?php
session_start();
if (!isset($_SESSION['user_id'])) exit();

include('include/db.php');

$user_id = $_SESSION['user_id'];
$message = trim($_POST['message']);

if (!empty($message)) {
    $stmt = $conn->prepare("INSERT INTO messages (sender_id, message, timestamp) VALUES (?, ?, NOW())");
    $stmt->bind_param("is", $user_id, $message);
    $stmt->execute();
}
?>
