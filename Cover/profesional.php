<?php
// Start the session first
session_start();

// Ensure user is logged in
if (!isset($_SESSION['email'])) {
    header("Location: ../index.php");
    exit();
}

// Get user email
$email = $_SESSION['email'];

// Include the navbar after session check
include ('navbar.php');
include ('controller.php');
include_once('dbconnect.php');
?>

    <style>
        .alert {
            padding: 15px;
            margin-bottom: 20px;
            border: 1px solid transparent;
            border-radius: 4px;
        }
        .alert.success {
            color: #3c763d;
            background-color: #dff0d8;
            border-color: #d6e9c6;
        }
        .alert.error {
            color: #a94442;
            background-color: #f2dede;
            border-color: #ebccd1;
        }
    </style>

    <div class="form-container">
        <form action="controller.php" method="POST" id="profesionalForm">
            
            <h2>Professional Background</h2>
            
            <div class="form-group">
                <label for="current_job_title">Current/Most Recent Job Title:</label>
                <input type="text" id="current_job_title" name="current_job_title" 
                       value="<?php echo isset($professional_details['current_job_title']) ? htmlspecialchars($professional_details['current_job_title']) : ''; ?>" required>
            </div>
            
            <div class="form-group">
                <label for="years_experience">Years of Experience in the Field:</label>
                <input type="number" id="years_experience" name="years_experience" min="0" 
                       value="<?php echo isset($professional_details['years_experience']) ? htmlspecialchars($professional_details['years_experience']) : ''; ?>" required>
            </div>
            
            <div class="form-group">
                <label for="key_skills">Key Skills (comma separated):</label>
                <textarea id="key_skills" name="key_skills" rows="3" required><?php echo isset($professional_details['key_skills']) ? htmlspecialchars($professional_details['key_skills']) : ''; ?></textarea>
            </div>
            
            <div class="form-group">
                <label for="notable_achievements">Notable Achievements/Accomplishments:</label>
                <textarea id="notable_achievements" name="notable_achievements" rows="5" required><?php echo isset($professional_details['notable_achievements']) ? htmlspecialchars($professional_details['notable_achievements']) : ''; ?></textarea>
            </div>

            <div class="form-group">
                <input type="submit" name="submit_profesional_details" value="Save Professional Details">
            </div>
            
        </form>
    </div>


<?php
    include('footer.php');
?>