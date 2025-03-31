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
        <form action="controller.php" method="POST" id="specificsForm">
            
            <h2>Application Specifics</h2>
            
            <div class="form-group">
                <label for="company_name">Company Name:</label>
                <input type="text" id="company_name" name="company_name" required>
            </div>
            
            <div class="form-group">
                <label for="position_applying_for">Position Applying For:</label>
                <input type="text" id="position_applying_for" name="position_applying_for" required>
            </div>
            
            <div class="form-group">
                <label for="hiring_manager">Hiring Manager's Name (if known):</label>
                <input type="text" id="hiring_manager" name="hiring_manager">
            </div>
            
            <div class="form-group">
                <label for="job_source">Where You Found the Job Listing:</label>
                <input type="text" id="job_source" name="job_source">
            </div>
            
            <div class="form-group">
                <input type="submit" name="submit_company_letter" value="Generate Cover Letter">
            </div>
        </form>
    </div>
</body>
</html>

<?php
    include('footer.php');
?>