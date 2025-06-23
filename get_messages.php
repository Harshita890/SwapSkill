<?php
session_start();
require("include/db.php");

if (!isset($_SESSION['user_id']) || !isset($_GET['other_user_id'])) {
    http_response_code(400);
    echo json_encode([]);
    exit();
}

$user_id = $_SESSION['user_id'];
$other_user_id = intval($_GET['other_user_id']);

$query = "
    SELECT * FROM chat_messages
    WHERE (sender_id = ? AND receiver_id = ?)
       OR (sender_id = ? AND receiver_id = ?)
    ORDER BY timestamp ASC
";

$stmt = $conn->prepare($query);
$stmt->bind_param("iiii", $user_id, $other_user_id, $other_user_id, $user_id);
$stmt->execute();
$result = $stmt->get_result();

$messages = [];
while ($row = $result->fetch_assoc()) {
    $messages[] = $row;
}

header('Content-Type: application/json');
echo json_encode($messages);
?>
