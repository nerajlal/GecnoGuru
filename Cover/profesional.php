<?php
include 'navbar.php';
include 'controller.php';

// Ensure user is logged in 
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
        <form action="controller.php" method="POST" id="profesionalForm">
            
            <h2>Professional Background</h2>
            
            <div class="form-group">
                <label for="current_job_title">Current/Most Recent Job Title:</label>
                <input type="text" id="current_job_title" name="current_job_title" required>
            </div>
            
            <div class="form-group">
                <label for="years_experience">Years of Experience in the Field:</label>
                <input type="number" id="years_experience" name="years_experience" min="0" required>
            </div>
            
            <div class="form-group">
                <label for="key_skills">Key Skills (comma separated):</label>
                <textarea id="key_skills" name="key_skills" rows="3" required></textarea>
            </div>
            
            <div class="form-group">
                <label for="notable_achievements">Notable Achievements/Accomplishments:</label>
                <textarea id="notable_achievements" name="notable_achievements" rows="5" required></textarea>
            </div>

            <div class="form-group">
                <input type="submit" name="submit_profesional_details" value="Save Profesional Details">
            </div>
            
        </form>
    </div>
</body>
</html>

<?php
    include('footer.php');
?>