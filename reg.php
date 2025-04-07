<?php
require_once ('controller.php');

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - GecnoGuru</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* Your existing navbar styles here */
        
        body {
            background-color: #2563eb;
            font-family: Arial, sans-serif;
            padding-top: 60px; /* For fixed navbar */
        }
        
        .login-container {
            max-width: 400px;
            margin: 50px auto;
            padding: 30px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
        }
        
        h2 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        label {
            display: block;
            margin-bottom: 8px;
            color: #555;
            font-weight: bold;
        }
        
        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
            font-size: 16px;
        }
        
        input:focus {
            border-color: #4285f4;
            outline: none;
            box-shadow: 0 0 0 2px rgba(66, 133, 244, 0.2);
        }
        
        .btn {
            width: 100%;
            padding: 12px;
            background-color: #333;
            color: white;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        
        .btn:hover {
            background-color: #555;
        }
        
        .error {
            color: #d32f2f;
            background-color: #fde8e8;
            padding: 10px;
            border-radius: 4px;
            margin-bottom: 20px;
            text-align: center;
        }
        
        .footer-links {
            text-align: center;
            margin-top: 20px;
            font-size: 14px;
        }
        
        .footer-links a {
            color: #4285f4;
            text-decoration: none;
        }
        
        .footer-links a:hover {
            text-decoration: underline;
        }

        .success {
            color: #388e3c;
            background-color: #e8f5e9;
            padding: 10px;
            border-radius: 4px;
            margin-bottom: 20px;
            text-align: center;
        }
    </style>
</head>
<body>
    <?php include ('navbar.php'); ?>
    
    <div class="login-container">
        <h2>Register for your account</h2>
            
        <?php if (isset($_SESSION['error'])): ?>
            <div class="error">
                <?php echo $_SESSION['error']; unset($_SESSION['error']); ?>
            </div>
        <?php endif; ?>

        <?php if (isset($_SESSION['success'])): ?>
            <div class="success">
                <?php echo $_SESSION['success']; unset($_SESSION['success']); ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="controller.php">
            <input type="hidden" name="action" value="register">
            
            <div class="form-group">
                <label for="email">Email address</label>
                <input type="email" id="email" name="email" required autofocus>
            </div>
            
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </div>

            <div class="form-group">
                <label for="confirm_password">Confirm Password</label>
                <input type="password" id="confirm_password" name="confirm_password" required>
            </div>
            
            <button type="submit" class="btn">Register Now</button>
        </form>

        
        <div class="footer-links">
            <a href="login.php">Already have an account</a>
        </div>
    </div>
</body>
</html>