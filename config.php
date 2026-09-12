<?php
// Database connection settings
$host = "localhost";
$db_user = "root";
$db_pass = "";
$db_name = "safe_rent";

$conn = new mysqli($host, $db_user, $db_pass, $db_name);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
