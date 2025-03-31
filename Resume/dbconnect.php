<?php
$host = 'localhost';
$user = 'root';
$pass = '';
$dbname = 'resume_builder';

// Create connection
$conn = new mysqli($host, $user, $pass);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Close initial connection and reconnect to the specific database
$conn->close();
$conn = new mysqli($host, $user, $pass, $dbname);

// Check database connection
if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

// Close the connection
$conn->close();
?>