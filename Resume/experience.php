<?php
include 'navbar.php';
include 'controller.php';

// Ensure user is logged in
if (!isset($_SESSION['user_email'])) {
    header("Location: personal.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Professional Experience</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <div class="form-container">
        <form action="controller.php" method="POST" id="experienceForm">
            <div id="experience-container">
                <div class="experience-entry">
                    <div class="form-group">
                        <label for="company_name_1">Company Name:</label>
                        <input type="text" id="company_name_1" name="company_name[]" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="job_title_1">Job Title:</label>
                        <input type="text" id="job_title_1" name="job_title[]" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="start_date_1">Start Date:</label>
                        <input type="date" id="start_date_1" name="start_date[]" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="end_date_1">End Date:</label>
                        <input type="date" id="end_date_1" name="end_date[]">
                    </div>
                    
                    <div class="form-group">
                        <label>
                            <input type="checkbox" name="is_current[0]" id="is_current_1" class="current-job-checkbox">
                            I currently work here
                        </label>
                    </div>
                    
                    <div class="form-group">
                        <label for="location_1">Location:</label>
                        <input type="text" id="location_1" name="location[]">
                    </div>
                    
                    <div class="form-group">
                        <label for="job_description_1">Job Description:</label>
                        <textarea id="job_description_1" name="job_description[]" rows="4"></textarea>
                    </div>
                </div>
            </div>

            <button type="button" class="add-education-btn" id="addExperienceBtn">
                <i class="fas fa-plus-circle"></i> Add Another Experience
            </button>
            
            <div class="form-group">
                <input type="submit" name="submit_experience_details" value="Save Experience Details">
            </div>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
        const experienceContainer = document.getElementById('experience-container');
        const addExperienceBtn = document.getElementById('addExperienceBtn');
        let experienceCount = 1;

        addExperienceBtn.addEventListener('click', function() {
            experienceCount++;
            
            // Create new experience entry
            const newEntry = document.createElement('div');
            newEntry.classList.add('experience-entry');
            newEntry.innerHTML = `

                <br><hr><br>

                <div class="form-group">
                    <label for="company_name_${experienceCount}">Company Name:</label>
                    <input type="text" id="company_name_${experienceCount}" name="company_name[]" required>
                </div>
                
                <div class="form-group">
                    <label for="job_title_${experienceCount}">Job Title:</label>
                    <input type="text" id="job_title_${experienceCount}" name="job_title[]" required>
                </div>
                
                <div class="form-group">
                    <label for="start_date_${experienceCount}">Start Date:</label>
                    <input type="date" id="start_date_${experienceCount}" name="start_date[]" required>
                </div>
                
                <div class="form-group">
                    <label for="end_date_${experienceCount}">End Date:</label>
                    <input type="date" id="end_date_${experienceCount}" name="end_date[]">
                </div>
                
                <div class="form-group">
                    <label>
                        <input type="checkbox" name="is_current[${experienceCount-1}]" id="is_current_${experienceCount}" class="current-job-checkbox">
                        I currently work here
                    </label>
                </div>
                
                <div class="form-group">
                    <label for="location_${experienceCount}">Location:</label>
                    <input type="text" id="location_${experienceCount}" name="location[]">
                </div>
                
                <div class="form-group">
                    <label for="job_description_${experienceCount}">Job Description:</label>
                    <textarea id="job_description_${experienceCount}" name="job_description[]" rows="4"></textarea>
                </div>
            `;
            
            experienceContainer.appendChild(newEntry);

            // Add event listener for current job checkbox
            const currentJobCheckbox = newEntry.querySelector('.current-job-checkbox');
            const endDateInput = newEntry.querySelector(`[name="end_date[]"]`);
            
            currentJobCheckbox.addEventListener('change', function() {
                endDateInput.disabled = this.checked;
                if (this.checked) {
                    endDateInput.value = ''; // Clear end date
                }
            });
        });

        // Handle current job checkbox for initial entry
        const initialCurrentJobCheckbox = document.querySelector('.current-job-checkbox');
        const initialEndDateInput = document.querySelector('[name="end_date[]"]');
        
        initialCurrentJobCheckbox.addEventListener('change', function() {
            initialEndDateInput.disabled = this.checked;
            if (this.checked) {
                initialEndDateInput.value = ''; // Clear end date
            }
        });
    });
    </script>
</body>
</html>

<?php
    include('footer.php');
?>