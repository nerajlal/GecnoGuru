


<?php
include 'navbar.php';
include 'controller.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Personal Details</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="form-container">
        <form action="controller.php" method="POST">
            <div class="form-group">
                <label for="name">Full Name:</label>
                <input type="text" id="name" name="name" required>
            </div>
            
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
            </div>
            
            <div class="form-group">
                <label for="phone">Phone Number:</label>
                <input type="tel" id="phone" name="phone" required>
            </div>
            
            <div class="form-group">
                <label for="address">Address:</label>
                <textarea id="address" name="address" rows="3"></textarea>
            </div>
            
            <div class="form-group">
                <label for="github">GitHub Profile:</label>
                <input type="url" id="github" name="github">
            </div>
            
            <div class="form-group">
                <label for="linkedin">LinkedIn Profile:</label>
                <input type="url" id="linkedin" name="linkedin">
            </div>
            
            <div class="form-group">
                <label for="job_role">Job Role:</label>
                <input type="text" id="job_role" name="job_role">
            </div>
            
            <div class="form-group">
                <label for="description">Professional Description:</label>
                <textarea id="description" name="description" rows="5"></textarea>
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