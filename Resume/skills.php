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
    <title>Skills and Expertise</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <div class="form-container">
        <form action="controller.php" method="POST" id="skillsForm">
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
</body>
</html>

<?php
    include('footer.php');
?>