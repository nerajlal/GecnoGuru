<?php
$host = 'localhost';
$user = 'root';
$pass = '';
$dbname = 'resume_builder';

// Create connection to specific database directly
$conn = new mysqli($host, $user, $pass, $dbname);

// Check connection
if ($conn->connect_error) {
    // If database doesn't exist, create it
    if ($conn->connect_errno == 1049) {
        $conn = new mysqli($host, $user, $pass);
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        
        // Create database
        $sql = "CREATE DATABASE IF NOT EXISTS $dbname";
        if ($conn->query($sql) === TRUE) {
            $conn->select_db($dbname);
            createTables($conn); // Create tables after DB creation
        } else {
            die("Error creating database: " . $conn->error);
        }
    } else {
        die("Connection failed: " . $conn->connect_error);
    }
}


$conn->set_charset("utf8mb4");
?>