<?php
$host = 'localhost';
$user = 'root';
$password = '';
$database = 'skillswap';

$conn = new mysql($host, $user, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>