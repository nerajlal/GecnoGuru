<?php
// Start the session first
session_start();

// Ensure user is logged in
if (!isset($_SESSION['email'])) {
    header("Location: index.php");
    exit();
}

// Get user email
$user_email = $_SESSION['email'];

// Include the navbar after session check
include('navbar1.php');
?>
    <div class="form-container">
        <form action="ucontroller.php" method="POST">
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


<?php
    include('footer.php');
?>