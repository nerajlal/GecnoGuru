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
        <form action="ucontroller.php" method="POST" id="skillsForm">
            <div id="skills-container">
                <div class="skills-entry">
                    
                    <div class="form-group">
                        <label for="skill_1">Skill/Expertise:</label>
                        <input type="text" id="skill_1" name="skill[]" required placeholder="e.g., Python, Graphic Design, Project Management">
                    </div>
                    
                    <div class="form-group">
                        <label for="skill_proficiency_1">Proficiency Level:</label>
                        <select id="skill_proficiency_1" name="skill_proficiency[]" required>
                            <option value="">Select Proficiency</option>
                            <option value="Beginner">Beginner</option>
                            <option value="Intermediate">Intermediate</option>
                            <option value="Advanced">Advanced</option>
                            <option value="Expert">Expert</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="skill_description_1">Description (Optional):</label>
                        <textarea id="skill_description_1" name="skill_description[]" rows="3" placeholder="Provide details about your skill or expertise"></textarea>
                    </div>
                </div>
            </div>

            <button type="button" class="add-education-btn" id="addSkillBtn">
                <i class="fas fa-plus-circle"></i> Add Another Skill
            </button>
            
            <div class="form-group">
                <input type="submit" name="submit_skills_details" value="Save Skills">
            </div>
        </form>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const skillsContainer = document.getElementById('skills-container');
        const addSkillBtn = document.getElementById('addSkillBtn');
        let skillCount = 1;

        addSkillBtn.addEventListener('click', function() {
            skillCount++;
            
            // Create new skill entry
            const newEntry = document.createElement('div');
            newEntry.classList.add('skills-entry');
            newEntry.innerHTML = `
                <br><hr><br>

                <div class="form-group">
                    <label for="skill_${skillCount}">Skill/Expertise:</label>
                    <input type="text" id="skill_${skillCount}" name="skill[]" required placeholder="e.g., Python, Graphic Design, Project Management">
                </div>
                
                <div class="form-group">
                    <label for="skill_proficiency_${skillCount}">Proficiency Level:</label>
                    <select id="skill_proficiency_${skillCount}" name="skill_proficiency[]" required>
                        <option value="">Select Proficiency</option>
                        <option value="Beginner">Beginner</option>
                        <option value="Intermediate">Intermediate</option>
                        <option value="Advanced">Advanced</option>
                        <option value="Expert">Expert</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="skill_description_${skillCount}">Description (Optional):</label>
                    <textarea id="skill_description_${skillCount}" name="skill_description[]" rows="3" placeholder="Provide details about your skill or expertise"></textarea>
                </div>
            `;
            
            skillsContainer.appendChild(newEntry);
        });
    });
    </script>


<?php
    include('footer.php');
?>