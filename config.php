<?php
// Database connection
$conn = mysqli_connect('localhost', 'root', '', 'players');

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
