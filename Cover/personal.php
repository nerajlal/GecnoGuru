<?php
include 'navbar.php';
include 'controller.php';

// Ensure user is logged in
// session_start();
if (!isset($_SESSION['email'])) {
    header("Location: personal.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cover Letter Builder</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <div class="form-container">
        <form action="controller.php" method="POST" id="personalForm">
            <h2>Basic Personal Information</h2>
            
            <div class="form-group">
                <label for="full_name">Full Name:</label>
                <input type="text" id="full_name" name="full_name" required>
            </div>
            
            <div class="form-group">
                <label for="professional_title">Professional Title/Position:</label>
                <input type="text" id="professional_title" name="professional_title" required>
            </div>
            
            <div class="form-group">
                <label for="email">Email Address:</label>
                <input type="email" id="email" name="email" required>
            </div>
            
            <div class="form-group">
                <label for="phone">Phone Number:</label>
                <input type="tel" id="phone" name="phone" required>
            </div>
            
            <div class="form-group">
                <label for="linkedin_url">LinkedIn Profile URL (optional):</label>
                <input type="url" id="linkedin_url" name="linkedin_url">
            </div>
            
            <div class="form-group">
                <label for="portfolio_url">Portfolio/Website (optional):</label>
                <input type="url" id="portfolio_url" name="portfolio_url">
            </div>
            
            <div class="form-group">
                <label for="address">Physical Address (optional):</label>
                <textarea id="address" name="address" rows="3"></textarea>
            </div>

            <div class="form-group">
                <input type="submit" name="submit_personal_details" value="Save Personal Details">
            </div>
            
        </form>
    </div>
</body>
</html>

<?php
    include('footer.php');
?>