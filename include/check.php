<?php
$file_path = 'include/db.php';
if (file_exists($file_path)) {
    include $file_path;
} else {
    die("Error: The file 'includes/db.php' does not exist.");
}
?>
