<?php
session_start();

// Check if a user is logged in
if (isset($_SESSION['user_id'])) {
    if (isset($_GET['confirm']) && $_GET['confirm'] === 'yes') {
        // Destroy the session and log out
        session_unset();
        session_destroy();
        header("Location: login.php?message=logged_out");
        exit();
    } else {
        // Show confirmation
        echo "<script>
            if (confirm('Are you sure you want to log out?')) {
                window.location.href = 'logout.php?confirm=yes';
            } else {
                window.location.href = 'dashboard.php';
            }
        </script>";
        exit();
    }
}

// If no user is logged in, redirect to login page directly
header("Location: login.php");
exit();
