<?php
$host = 'localhost';
$user = 'root';
$pass = '';
$dbname = 'resume_builder';

// Create connection
$conn = new mysqli($host, $user, $pass);

// Check connection
if ($conn->connect_error) {
    die("Initial connection failed: " . $conn->connect_error);
}

// Create database if not exists
$conn->query("CREATE DATABASE IF NOT EXISTS $dbname");

// Select database
$conn->select_db($dbname);

// Set charset
$conn->set_charset("utf8mb4");

// Make connection available globally
function get_db_connection() {
    global $conn;
    return $conn;
}
?>