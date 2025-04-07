<?php
require_once ('dbconnect.php');

session_start();

function sanitizeInput($data) {
    global $conn;
    return htmlspecialchars(strip_tags(trim($conn->real_escape_string($data))));
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = isset($_POST['action']) ? $_POST['action'] : '';
    
    if ($action === 'register') {
        // Handle registration
        $email = sanitizeInput($_POST['email']);
        $password = sanitizeInput($_POST['password']);
        $confirm_password = sanitizeInput($_POST['confirm_password']);
        
        // Validate inputs
        if (empty($email) || empty($password) || empty($confirm_password)) {
            $_SESSION['error'] = "All fields are required!";
            header("Location: reg.php");
            exit();
        }
        
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $_SESSION['error'] = "Invalid email format!";
            header("Location: reg.php");
            exit();
        }
        
        if ($password !== $confirm_password) {
            $_SESSION['error'] = "Passwords don't match!";
            header("Location: reg.php");
            exit();
        }
        
        if (strlen($password) < 6) {
            $_SESSION['error'] = "Password must be at least 6 characters!";
            header("Location: reg.php");
            exit();
        }
        
        // Check if email already exists
        $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();
        
        if ($stmt->num_rows > 0) {
            $_SESSION['error'] = "Email already registered!";
            header("Location: reg.php");
            exit();
        }
        
        // Hash password
        // $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        
        // Insert new user
        $stmt = $conn->prepare("INSERT INTO users (email, password) VALUES (?, ?)");
        $stmt->bind_param("ss", $email, $password);
        
        if ($stmt->execute()) {
            $_SESSION['success'] = "Registration successful! Please login.";
            header("Location: login.php");
        } else {
            $_SESSION['error'] = "Registration failed: " . $conn->error;
            header("Location: reg.php");
        }
        exit();
        
    } elseif ($action === 'login') {
        // Handle login
        $email = sanitizeInput($_POST['email']);
        $password = sanitizeInput($_POST['password']);
        
        // Validate inputs
        if (empty($email) || empty($password)) {
            $_SESSION['error'] = "Email and password are required!";
            header("Location: login.php");
            exit();
        }
        
        // Get user from database
        $stmt = $conn->prepare("SELECT id, email, password FROM users WHERE email = ? AND password = ?");
        $stmt->bind_param("ss", $email, $password);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();
            
            // Login successful
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['email'] = $user['email'];
            
            header("Location: index1.php");
            exit();
        } else {
            $_SESSION['error'] = "Invalid email or password!";
            header("Location: login.php");
            exit();
        }
    }
}

?>