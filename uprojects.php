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
        <form action="ucontroller.php" method="POST" id="projectsForm">
            <div id="projects-container">
                <div class="project-entry">
                    <div class="form-group">
                        <label for="project_name_1">Project Name:</label>
                        <input type="text" id="project_name_1" name="project_name[]" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="project_description_1">Project Description:</label>
                        <textarea id="project_description_1" name="project_description[]" rows="4" required></textarea>
                    </div>
                    
                    <div class="form-group">
                        <label for="technologies_1">Technologies Used:</label>
                        <input type="text" id="technologies_1" name="technologies[]" placeholder="e.g., React, Node.js, Python">
                    </div>
                    
                    <div class="form-group">
                        <label for="project_link_1">Project Link (Optional):</label>
                        <input type="url" id="project_link_1" name="project_link[]" placeholder="GitHub, Live Demo, etc.">
                    </div>
                    
                    <div class="form-group">
                        <label for="start_date_1">Start Date:</label>
                        <input type="date" id="start_date_1" name="start_date[]">
                    </div>
                    
                    <div class="form-group">
                        <label for="end_date_1">End Date:</label>
                        <input type="date" id="end_date_1" name="end_date[]">
                    </div>
                </div>
            </div>

            <button type="button" class="add-education-btn" id="addProjectBtn">
                <i class="fas fa-plus-circle"></i> Add Another Project
            </button>
            
            <div class="form-group">
                <input type="submit" name="submit_projects_details" value="Save Project Details">
            </div>
        </form>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const projectsContainer = document.getElementById('projects-container');
        const addProjectBtn = document.getElementById('addProjectBtn');
        let projectCount = 1;

        addProjectBtn.addEventListener('click', function() {
            projectCount++;
            
            // Create new project entry
            const newEntry = document.createElement('div');
            newEntry.classList.add('project-entry');
            newEntry.innerHTML = `

                <br><hr><br>

                <div class="form-group">
                    <label for="project_name_${projectCount}">Project Name:</label>
                    <input type="text" id="project_name_${projectCount}" name="project_name[]" required>
                </div>
                
                <div class="form-group">
                    <label for="project_description_${projectCount}">Project Description:</label>
                    <textarea id="project_description_${projectCount}" name="project_description[]" rows="4" required></textarea>
                </div>
                
                <div class="form-group">
                    <label for="technologies_${projectCount}">Technologies Used:</label>
                    <input type="text" id="technologies_${projectCount}" name="technologies[]" placeholder="e.g., React, Node.js, Python">
                </div>
                
                <div class="form-group">
                    <label for="project_link_${projectCount}">Project Link (Optional):</label>
                    <input type="url" id="project_link_${projectCount}" name="project_link[]" placeholder="GitHub, Live Demo, etc.">
                </div>
                
                <div class="form-group">
                    <label for="start_date_${projectCount}">Start Date:</label>
                    <input type="date" id="start_date_${projectCount}" name="start_date[]">
                </div>
                
                <div class="form-group">
                    <label for="end_date_${projectCount}">End Date:</label>
                    <input type="date" id="end_date_${projectCount}" name="end_date[]">
                </div>

            `;
            
            projectsContainer.appendChild(newEntry);
        });
    });
    </script>

<?php
    include('footer.php');
?>