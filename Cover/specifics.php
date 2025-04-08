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
        <form action="controller.php" method="POST" id="specificsForm">
            
            <h2>Application Specifics</h2>
            
            <div class="form-group">
                <label for="company_name">Company Name:</label>
                <input type="text" id="company_name" name="company_name" 
                       value="<?php echo isset($application_specifics['company_name']) ? htmlspecialchars($application_specifics['company_name']) : ''; ?>" required>
            </div>
            
            <div class="form-group">
                <label for="position_applying_for">Position Applying For:</label>
                <input type="text" id="position_applying_for" name="position_applying_for" 
                       value="<?php echo isset($application_specifics['position_applying_for']) ? htmlspecialchars($application_specifics['position_applying_for']) : ''; ?>" required>
            </div>
            
            <div class="form-group">
                <label for="hiring_manager">Hiring Manager's Name (if known):</label>
                <input type="text" id="hiring_manager" name="hiring_manager"
                       value="<?php echo isset($application_specifics['hiring_manager']) ? htmlspecialchars($application_specifics['hiring_manager']) : ''; ?>">
            </div>
            
            <div class="form-group">
                <label for="job_source">Where You Found the Job Listing:</label>
                <input type="text" id="job_source" name="job_source"
                       value="<?php echo isset($application_specifics['job_source']) ? htmlspecialchars($application_specifics['job_source']) : ''; ?>">
            </div>
            
            <div class="form-group">
                <input type="submit" name="submit_company_letter" value="Generate Cover Letter">
            </div>
        </form>
    </div>


<?php
    include('footer.php');
?>