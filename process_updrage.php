<?php
session_start();
require("include/db.php");

if(!isset($_SESSION['user_id'])){
    header("location: login.php");
    exit;
}

mysqli_query($conn, "UPDATE users SET is_premium = 1 WHERE id = ".$_SESSION['user_id']);

$_SESSION['message'] = "You are now a premium member!";
header("location: skills.php");